<?php

declare(strict_types=1);

namespace Domain\Catalog\Providers;

use Illuminate\Support\ServiceProvider;

final class CatalogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class,
        );
    }
}
