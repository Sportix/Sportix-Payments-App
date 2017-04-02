<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Product;
use Carbon\Carbon;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;
use App\OrderTransactionNumberGenerator;

class PurchaseProductsTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function makeAPayment($product, $params)
    {
        $this->response = $this->json('POST', "/products/{$product->id}/orders", $params);
    }

    private function assertValidationError($field)
    {
        $this->assertResponseStatus(422);
        $this->assertArrayHasKey($field, $this->decodeResponseJson());
    }

    /** @test */
    public function a_user_can_make_a_payment_on_a_published_product()
    {
        //$this->disableExceptionHandling();
        // Create a new product with a specific fee
        $product = factory(Product::class)->states('openlive')->create([
            'payment_amount' => 2000, 'charge_app_fee' => true, 'app_fee_percent' => 2
        ]);

        $orderTransactionNumberGenerator = Mockery::mock(OrderTransactionNumberGenerator::class, [
            'generate' => 'TRANSACTIONID1234',
        ]);
        $this->app->instance(OrderTransactionNumberGenerator::class, $orderTransactionNumberGenerator);

        // JSON API Request from the UI
        $this->makeAPayment($product, [
            'email' => 'brad@me.com',
            'total_amount' => 2040,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertResponseStatus(201);

        $this->seeJsonSubset([
            'transaction_id' => 'TRANSACTIONID1234',
            'email' => 'brad@me.com',
            'total_amount' => 2040
        ]);

        // Assert - An order exists for this payment
        $this->assertEquals(2040, $this->paymentGateway->totalCharges());

        $order = $product->orders()
            ->where('product_id', $product->id)
            ->where('product_type', 'FUND')
            ->where('email', 'brad@me.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals(2040, $order->total_amount);
    }

    /** @test */
    public function cannot_make_a_payment_on_a_nonpublished_product()
    {
        $product = factory(Product::class)->states('unpublished')->create();

        $this->makeAPayment($product, [
            'email' => 'brad@me.com',
            'total_amount' => 3500,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertResponseStatus(404);
        $this->assertEquals(0, $product->orders()->count());
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    public function email_is_required_to_make_a_payment()
    {
        $product = factory(Product::class)->states('published')->create([]);

        $this->makeAPayment($product, [
            'total_amount' => 3500,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('email');
    }

    /** @test */
    public function email_must_be_valid_to_make_a_payment()
    {
        $product = factory(Product::class)->states('published')->create([]);

        $this->makeAPayment($product, [
            'email' => 'not-an-email-address',
            'total_amount' => 3500,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $this->assertValidationError('email');
    }

    /** @test */
    public function it_verifies_a_payment_token_is_required()
    {
        $product = factory(Product::class)->states('published')->create([]);

        $this->makeAPayment($product, [
            'email' => 'brad@me.com',
            'total_amount' => 3500,
        ]);

        $this->assertValidationError('payment_token');
    }

    /** @test */
    public function verify_a_non_invited_user_cannot_purchase_a_private_product()
    {
        // TODO: Finish this test
        $this->assertEquals(1, 1);
    }

    /** @test */
    public function verify_a_user_cannot_make_a_payment_after_due_date()
    {
        //$this->disableExceptionHandling();
        $product = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('-1 week')
        ]);

        $this->makeAPayment($product, [
            'email' => 'brad@me.com',
            'total_amount' => $product->payment_amount,
            'payment_token' => $this->paymentGateway->getValidTestToken()
        ]);

        $order = $product->orders()
            ->where('product_id', $product->id)
            ->where('product_type', 'FUND')
            ->where('email', 'brad@me.com')
            ->first();

        // 422 - Unprocessed Entity
        $this->assertResponseStatus(422);
        $this->assertNull($order);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }

    /** @test */
    public function an_order_is_not_created_if_payment_fails()
    {
        //$this->disableExceptionHandling();
        $product = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('+1 week')
        ]);

        $this->makeAPayment($product, [
            'email' => 'brad@me.com',
            'total_amount' => 3500,
            'payment_token' => 'invalid-payment-token'
        ]);

        // 422 - Unprocessed Entity
        $this->assertResponseStatus(422);
        $order = $product->orders()
                    ->where('product_id', $product->id)
                    ->where('email', 'brad@me.com')
                    ->where('product_type', 'FUND')->first();
        $this->assertNull($order);
    }

}
