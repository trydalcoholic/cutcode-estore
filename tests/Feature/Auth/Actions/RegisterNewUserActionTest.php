<?php

declare(strict_types=1);

namespace Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTO\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @returns void
     */
    public function it_success_user_create(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'testing@ya.ru',
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('Test', 'testing@ya.ru', '1234567890'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing@ya.ru',
        ]);
    }
}
