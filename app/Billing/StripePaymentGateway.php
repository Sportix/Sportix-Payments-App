<?php

namespace App\Billing;

use App\Billing\Charge;
use Stripe\Error\InvalidRequest;

class StripePaymentGateway implements PaymentGateway
{
    const TEST_CARD_NUMBER = '4242424242424242';

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function charge($amount, $token)
    {
        try {
            $stripeCharge = \Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $token,
                "description" => "Test Charge"
            ], ['api_key' => $this->apiKey]);

            return new Charge([
               'amount' => $stripeCharge['amount'],
               'card_last_four' => $stripeCharge['source']['last4']
            ]);

        } catch(InvalidRequest $e) {
            throw new PaymentFailedException;
        }
    }

    public function getValidTestToken($cardNumber = self::TEST_CARD_NUMBER)
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => $cardNumber,
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

        return $this->newChargesSince($lastestCharge)->map(function($stripeCharge) {
            return new Charge([
                'amount' => $stripeCharge['amount'],
                'card_last_four' => $stripeCharge['source']['last4']
            ]);
        });
    }

    private function lastCharge()
    {
        return array_first(\Stripe\Charge::all([
            'limit' => 1
        ], ['api_key' => $this->apiKey])['data']);
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
