<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use App\Billing\PaymentGateway;
use App\Billing\StripePaymentGateway;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\RandomOrderTransactionNumberGenerator;
use App\OrderTransactionNumberGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fix the Access Violation error for Laravel 5.4
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind(StripePaymentGateway::class, function() {
           return new StripePaymentGateway(config('services.stripe.secret'));
        });

        $this->app->bind(PaymentGateway::class, StripePaymentGateway::class);
        $this->app->bind(OrderTransactionNumberGenerator::class, RandomOrderTransactionNumberGenerator::class);

    }
}
