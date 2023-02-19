<?php

declare(strict_types=1);

namespace Domain\Auth\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }

    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class,
        );
    }
}
