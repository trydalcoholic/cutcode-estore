<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function page(): Application|Factory|View
    {
        return view('auth.login');
    }

    public function handle(LoginFormRequest $request): RedirectResponse
    {
        if (! auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'E-mail или пароль указаны неверно!',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        request()?->session()->invalidate();

        request()?->session()->regenerateToken();

        return redirect()->route('home');
    }
}
