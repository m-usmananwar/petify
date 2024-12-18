<?php

namespace App\Providers;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\Relation;
use Laravel\Cashier\Cashier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useSubscriptionModel(Subscription::class);
        Relation::enforceMorphMap([
            'User' => 'App\Models\User',
            'Auction' => 'App\Models\Auction',
        ]);
    }
}
