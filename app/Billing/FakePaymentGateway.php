<?php

namespace App\Billing;

class FakePaymentGateway implements PaymentGateway
{
    const TEST_CARD_NUMBER = '4242424242424242';

    private $charges;
    private $tokens;
    private $beforeFirstChargeCallback;

    public function __construct()
    {
        $this->charges = collect();
        $this->tokens = collect();
    }

    /**
     * Returns a valid Stripe Customer Test Id
     *
     * @return string
     */
    public function getValidStripeCustomerId()
    {
        return 'cust-00000000';
    }

    /**
     * Returns an invalid Stripe Customer Id
     *
     * @return string
     */
    public function getInvalidStripeCustomerId()
    {
        return 'bad-cust-000000';
    }

    /**
     * Returns a valid test token
     *
     * @return string
     */
    public function getValidTestToken($cardNumber = self::TEST_CARD_NUMBER)
    {
        $token = 'fake-tok_' . str_random(24);
        $this->tokens[$token] = $cardNumber;
        return $token;
    }

    /**
     * Returns an invalid test token
     *
     * @return string
     */
    public function getInvalidTestToken()
    {
        return 'invalid-test-token';
    }

    /**
     * Add amount to charges array
     *
     * @param $amount
     * @param $token
     */
    public function charge($amount, $token)
    {
        if ($this->beforeFirstChargeCallback !== null) {
            $this->beforeFirstChargeCallback->__invoke($this);
        }

        if( ! $this->tokens->has($token)) {
            throw new PaymentFailedException;
        }

        return $this->charges[] = new Charge([
            'amount' => $amount,
            'card_last_four' => substr($this->tokens[$token], -4)
        ]);
    }

    public function newChargesDuring($callback)
    {
        $chargesFrom = $this->charges->count();
        $callback($this); // pass in the Gateway itself

        return $this->charges->slice($chargesFrom)->reverse()->values();
    }

    /**
     * Get the total sum of all charges
     *
     * @return mixed
     */
    public function totalCharges()
    {
        return $this->charges->map->amount()->sum();
    }

    public function beforeFirstCharge($callback)
    {
        $this->beforeFirstChargeCallback = $callback;
    }
}
