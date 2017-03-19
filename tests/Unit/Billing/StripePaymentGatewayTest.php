<?php
namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\StripePaymentGateway;
use App\Billing\PaymentFailedException;

/**
 * @group wifi
 * Note: No Internet? $> phpunit --exclude-group wifi
 */
class StripePaymentGatewayTest extends TestCase
{
    use PaymentGatewayContractsTests;

    protected function getPaymentGateway()
    {
        return new StripePaymentGateway(config('services.stripe.secret'));
    }

}
