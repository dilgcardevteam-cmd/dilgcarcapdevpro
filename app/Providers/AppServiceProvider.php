<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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

        $appUrl = trim((string) config('app.url'));
        if ($appUrl !== '') {
            URL::forceRootUrl(rtrim($appUrl, '/'));

            $scheme = strtolower((string) parse_url($appUrl, PHP_URL_SCHEME));
            if ($scheme === 'https' || filter_var(env('APP_FORCE_HTTPS', false), FILTER_VALIDATE_BOOL)) {
                URL::forceScheme('https');
            }
        }
    }
}
