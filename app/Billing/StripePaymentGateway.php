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
}
