<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingServiceProvider extends ServiceProvider
{
    const BINDINGS = [
        \App\Modules\Authentication\Repositories\Interfaces\IAuthenticationRepository::class => \App\Modules\Authentication\Repositories\AuthenticationRepository::class,
        \App\Modules\Authentication\Repositories\Interfaces\IVerificationRepository::class => \App\Modules\Authentication\Repositories\VerificationRepository::class,
        \App\Modules\Subscription\Repositories\Interfaces\ISubscriptionRepository::class => \App\Modules\Subscription\Repositories\SubscriptionRepository::class,
        \App\Modules\Subscription\Repositories\Interfaces\ISubscriptionPlanRepository::class => \App\Modules\Subscription\Repositories\SubscriptionPlanRepository::class,
        \App\Modules\Auction\Repositories\Interfaces\IAuctionRepository::class => \App\Modules\Auction\Repositories\AuctionRepository::class,
        \App\Modules\Bid\Repositories\Interfaces\IBidRepository::class => \App\Modules\Bid\Repositories\BidRepository::class,
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
