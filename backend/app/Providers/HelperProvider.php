<?php

namespace App\Providers;

use App\Services\HelperServices;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind(HelperServices::class, function () {
            return new HelperServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
