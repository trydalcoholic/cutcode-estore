<?php

declare(strict_types=1);

namespace Auth\DTO;

use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\DTO\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new RegisterFormRequest([
            'name' => 'test',
            'email' => 'testing@cutcode.ru',
            'password' => '12345',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
