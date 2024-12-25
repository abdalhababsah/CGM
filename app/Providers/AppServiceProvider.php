<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DeliveryService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DeliveryService::class, function ($app) {
            return new DeliveryService();
        });
    }

    public function boot()
    {
        //
    }
}