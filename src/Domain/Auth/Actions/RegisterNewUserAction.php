<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTO\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
