<?php

namespace App\Billing;

use Stripe\Error\InvalidRequest;

class StripePaymentGateway implements PaymentGateway
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function charge($amount, $token)
    {
        try {
            \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $token,
                "description" => "Test Charge"
            ], ['api_key' => $this->apiKey]);
        } catch(InvalidRequest $e) {
            throw new PaymentFailedException;
        }
    }

    public function getValidTestToken()
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => $this->apiKey])->id;
    }

    public function newChargesDuring($callback)
    {
        $lastestCharge = $this->lastCharge();
        $callback($this); // pass in the Gateway itself

        return $this->newChargesSince($lastestCharge)->pluck('amount');
    }

    private function lastCharge()
    {
        // Checks for 'whiping out' all data kind of check
        return \Stripe\Charge::all(
            ['limit' => 1],
            ['api_key' => $this->apiKey]
        )['data'][0];
    }

    public function newChargesSince($charge = null)
    {
        $newCharges = \Stripe\Charge::all(
            [
                'ending_before' => $charge ? $charge->id : null, // Makes sure we are dealing with a latest charge
            ],
            ['api_key' => $this->apiKey]
        )['data'];

        return collect($newCharges);
    }
}
