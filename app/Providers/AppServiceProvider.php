<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LedgerService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('ledger', function ($app) {
            return new LedgerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
