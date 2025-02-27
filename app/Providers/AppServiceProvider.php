<?php

namespace App\Providers;

use App\Models\Manufactur;
use App\Observers\ManufacturObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        Manufactur::observe(ManufacturObserver::class);
    }
}
