<?php

namespace App\Providers;

use App\Contract\CardPaymentInterface;
use App\Observers\UserObserver;
use App\Services\JXApiClient;
use App\Services\NapTheNhanhPayment;
use App\Services\RecardPayment;
use App\User;
use function foo\func;
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
        \Voyager::addAction(\App\Action\RejectPaymentAction::class);
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

        $this->app->singleton(CardPaymentInterface::class, function($app) {
            if (env('CARD_PAYMENT_PARTNER') == CardPaymentInterface::PARTNER_NAPTHENHANH) {
                $service = new NapTheNhanhPayment(
                    env('NAPTHENHANH_PARTNER_ID'),
                    env('NAPTHENHANH_PARTNER_KEY')
                );
            } else {
                $service = new RecardPayment(
                    env('RECARD_MERCHANT_ID'),
                    env('RECARD_SECRET_KEY')
                );
            }

            return $service;
       });
    }
}
