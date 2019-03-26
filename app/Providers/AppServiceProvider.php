<?php

namespace App\Providers;

use App\Observers\UserObserver;
use App\Services\JXApiClient;
use App\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Paginator::defaultView('vendor.pagination.default');
        \Voyager::addAction(\App\Action\AcceptPaymentAction::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(JXApiClient::class, function ($app) {
            $baseUrl = env('GAME_API_BASE_URL', '');
            $apiKey = env('GAME_API_KEY', '');

            return new JXApiClient($baseUrl, $apiKey);
        });
    }
}
