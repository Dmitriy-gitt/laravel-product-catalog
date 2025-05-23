<?php

namespace App\Providers;

use App\Contracts\IProductServices;
use App\Services\ProductServices;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(IProductServices::class, ProductServices::class);
    }
}
