<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFromRequest;
use App\Http\Requests\ResetPasswordFromRequest;
use App\Http\Requests\SignInFromRequest;
use App\Http\Requests\SignUpFromRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index(): Application|Factory|View
    {
        return view('auth.sign-in');
    }

    public function signIn(SignInFromRequest $request): RedirectResponse
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'E-mail или пароль указаны неверно!',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function signUp(): Application|Factory|View
    {
        return view('auth.sign-up');
    }

    public function store(SignUpFromRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        request()?->session()->invalidate();

        request()?->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function forgot(): Application|Factory|View
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordFromRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));

            return back();
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token): Application|Factory|View
    {
        return view('auth.reset-password',
            ['token' => $token]
        );
    }

    public function resetPassword(ResetPasswordFromRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            static function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            flash()->info(__($status));

            return redirect()->route('login');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    public function github(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(40)),
        ]);

        auth()->login($user);

        return redirect()
            ->intended(route('home'));
    }
}
