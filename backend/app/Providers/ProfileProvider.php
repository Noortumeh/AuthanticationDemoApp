<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Services\{HelperServices, ProfileService};


class ProfileProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // App::bind('welcome', function () {
        //     return new HelperServices();
        // });
        
        App::bind(ProfileService::class, function () {
            return new ProfileService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    //    $this->provides();
    }
    // public function provides(): void
    // {
    //     echo 'welcome all';
    // }
}
