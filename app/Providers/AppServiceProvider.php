<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');

        // Force HTTPS for all URLs
        URL::forceScheme('https');

        // If you want to only do this in production, keep your existing check
        // if (config('app.env') !== 'local')
        // {
        //     URL::forceScheme('https');
        // }
    }
}
