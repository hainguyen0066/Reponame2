<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::any('/payment/transaction-alert', [
            'uses' => '\App\Http\Controllers\Front\PaymentController@alertTransaction',
            'as' => 'front.payment.transaction_alert'
        ]);

        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace($this->namespace . "\Front")
            ->group(base_path('routes/front.php'));

        Route::post('/payment/recard', [
            'uses' => '\App\Http\Controllers\Front\PaymentController@recardCallback',
            'as' => 'front.payment.recard_callback'
        ]);

        Route::any('/payment/card-callback', [
            'uses' => '\App\Http\Controllers\Front\PaymentController@cardPaymentCallback',
            'as' => 'front.payment.card_payment_callback'
        ]);
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
