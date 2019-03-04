<?php

namespace App\Providers;

use App\Services\GameApiClient;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GameApiClient::class, function ($app) {
            $baseUrl = env('GAME_API_BASE_URL', '');
            $endpoint = env('GAME_API_ENDPOINT', '');
            $apiKey = env('GAME_API_KEY', '');

            return new GameApiClient($baseUrl, $endpoint, $apiKey);
        });
    }
}
