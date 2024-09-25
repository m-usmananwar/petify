<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    const BINDINGS = [
        \App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository::class => \App\Modules\Authentication\Repositories\AuthenticationRepository::class,
    ];

    public function register()
    {
        foreach (self::BINDINGS as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
