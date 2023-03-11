<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class AppRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(static function () {
            Route::get('/', HomeController::class)->name('home');

            Route::get('/storage/images/{dir}/{method}/{size}/{file}', ImageController::class)
                ->where('method', 'resize|crop|fit')
                ->where('size', '\d+x\d+')
                ->where('file', '.+\.(jpg|jpeg|png|gif|bmp|webp|avif|svg)$')
                ->name('image');
        });
    }
}
