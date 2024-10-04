<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Modules\Authentication\Events\WelcomeEvent::class => [
            \App\Modules\Authentication\Listeners\WelcomeEventListener::class,
        ],

        \App\Modules\Authentication\Events\OTPVerificationEvent::class => [
            \App\Modules\Authentication\Listeners\OTPVerificationEventListener::class,
        ],
    ];

    public function boot()
    {

    }
}
