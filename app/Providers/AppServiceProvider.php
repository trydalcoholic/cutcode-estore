<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(static function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query longer then 100ms: ' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                static function () {
                    logger()
                        ->channel('telegram')
                        ->debug('whenQueryingForLongerThan: ' . request()->url());
                }
            );
        }
    }
}
