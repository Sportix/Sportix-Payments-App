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
    protected function setUp()
    {
        parent::setUp();
        $this->lastCharge = $this->getLastCharge();
    }

    private function getLastCharge()
    {
        // Checks for 'whiping out' all data kind of check
        return \Stripe\Charge::all(
            ['limit' => 1],
            ['api_key' => config('services.stripe.secret')]
        )['data'][0];
    }

    private function getValidToken()
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => config('services.stripe.secret')])->id;
    }

    public function getNewCharge()
    {
        return \Stripe\Charge::all(
            [
                'limit' => 1,
                'ending_before' => $this->lastCharge, // Makes sure we are dealing with a latest charge
            ],
            ['api_key' => config('services.stripe.secret')]
        )['data'];
    }

    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new StripePaymentGateway(config('services.stripe.secret'));
        $paymentGateway->charge(2500, $this->getValidToken());

        $this->assertCount(1, $this->getNewCharge());
        $this->assertEquals(2500, $this->getLastCharge()->amount);
    }

    /** @test */
    public function charges_with_invalid_token_respond_with_error()
    {
        try {
            $paymentGateway = new StripePaymentGateway(config('services.stripe.secret'));
            $paymentGateway->charge(2500, 'invalid-payment-token');
        } catch(PaymentFailedException $e) {
            $this->assertCount(0, $this->getNewCharge());
            return;
        }

        $this->fail('Charging with invalid payment token did not throw invalid-payment-token ');
    }
}
