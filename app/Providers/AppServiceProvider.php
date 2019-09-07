<?php

namespace App\Providers;

use App\Contract\CardPaymentInterface;
use App\Models\Payment;
use App\Observers\PaymentObserver;
use App\Observers\UserObserver;
use App\Services\JXApiClient;
use App\Services\NapTheNhanhPayment;
use App\Services\RecardPayment;
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
        Payment::observe(PaymentObserver::class);
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

        $this->registerCardPaymentService();
    }

    private function registerCardPaymentService()
    {
        $this->app->singleton(RecardPayment::class, function ($app) {
            $service = new RecardPayment(
                env('RECARD_MERCHANT_ID'),
                env('RECARD_SECRET_KEY')
            );
            $service->setLogger(\Log::channel('card_payment'));

            return $service;
        });

        $this->app->singleton(NapTheNhanhPayment::class, function ($app) {
            $service = new NapTheNhanhPayment(
                env('NAPTHENHANH_PARTNER_ID'),
                env('NAPTHENHANH_PARTNER_KEY')
            );
            $service->setLogger(\Log::channel('card_payment'));

            return $service;
        });

        $this->app->singleton(CardPaymentInterface::class, function($app) {
            $partnerSetting = \Voyager::setting('site.card_payment_partner', env('CARD_PAYMENT_PARTNER'));
            if ($partnerSetting == CardPaymentInterface::PARTNER_NAPTHENHANH) {
                return app(NapTheNhanhPayment::class);
            } else {
                return app(RecardPayment::class);
            }
        });
    }
}
