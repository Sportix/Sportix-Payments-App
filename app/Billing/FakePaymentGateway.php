<?php

namespace App\Billing;

class FakePaymentGateway implements PaymentGateway
{
    private $charges;
    private $beforeFirstChargeCallback;

    public function __construct()
    {
        $this->charges = collect();
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
    public function getValidTestToken()
    {
        return 'test-token';
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

        if($token !== $this->getValidTestToken()) {
            throw new PaymentFailedException;
        }

        $this->charges[] = $amount;
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
        return $this->charges->sum();
    }

    public function beforeFirstCharge($callback)
    {
        $this->beforeFirstChargeCallback = $callback;
    }
}
