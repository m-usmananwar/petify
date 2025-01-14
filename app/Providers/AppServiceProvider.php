<?php

namespace App\Providers;

use App\Models\Subscription;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $this->configureCommands();
        $this->configureUrl();

        Cashier::useSubscriptionModel(Subscription::class);
        Relation::enforceMorphMap([
            'User' => 'App\Models\User',
            'Auction' => 'App\Models\Auction',
        ]);
    }

    private function configureCommands(): void
    {
        if(config('app.env') === 'production') DB::prohibitDesctructiveCommands();
    }

    private function configureUrl(): void
    {
        if(config('app.env') === 'production') URL::forceScheme('https');
    }
}
