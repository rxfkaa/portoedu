<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        // Seluruh aplikasi memakai Bootstrap, sehingga pagination juga harus
        // memakai markup Bootstrap (bukan template Tailwind bawaan Laravel).
        Paginator::useBootstrapFive();
    }
}
