<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL; // <-- Tambahkan ini
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS hanya saat environment adalah production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}