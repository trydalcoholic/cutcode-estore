<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page(): Application|Factory|View
    {
        return view('auth.register');
    }

    public function handle(RegisterFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return redirect()->intended(route('home'));
    }
}
