<?php

namespace App\Providers;

use App\Services\AdminServices;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        App::bind(AdminServices::class, function(){
            return new AdminServices();
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
