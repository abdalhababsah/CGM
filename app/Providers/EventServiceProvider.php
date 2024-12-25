<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderToDeliveryService;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [
            SendOrderToDeliveryService::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}