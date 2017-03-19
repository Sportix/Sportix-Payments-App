<?php
namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FakePaymentGatewayTest extends TestCase {

    use PaymentGatewayContractsTests;

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway;
    }

    /** @test */
    public function it_can_run_a_hook_before_the_first_charge()
    {
        $paymentGateway = new FakePaymentGateway;
        $callbackRan = false;

        $paymentGateway->beforeFirstCharge(function ($paymentGateway) use (&$callbackRan) {
            $callbackRan = true;
            $this->assertEquals(0, $paymentGateway->totalCharges());
        });

        $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());
        $this->assertTrue($callbackRan);
        $this->assertEquals(2500, $paymentGateway->totalCharges());
    }
}
