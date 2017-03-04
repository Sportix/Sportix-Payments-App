<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use App\Order;
use Carbon\Carbon;

class OrderTest extends TestCase
{
    /** @test */
    public function it_can_convert_to_an_array()
    {
        $product = factory(Product::class)->states('openlive')->create();
        $order = $product->makePayment('brad@me.com');

        $result = $order->toArray();

        $this->assertEquals([
            'id' => $order->id,
            'email' => $order->email,
            'total_amount' => $order->total_amount,
            'product_amount' => $order->product_amount,
            'app_fee_percent' => $order->app_fee_percent,
            'charge_app_fee' => $order->charge_app_fee,
            'created_at' => $order->created_at->format('Y-m-d')
        ], $result);
    }

    /** @test */
    public function cancel_an_order_after_failed_payment()
    {
        $product = factory(Product::class)->states('openlive')->create();

        $order = $product->makePayment('brad@me.com');
        $order->cancel();

        $this->assertNull(Order::find($order->id)); // Note: already have it in memory. Get it again
    }

    /** @test */
    public function it_charges_applicable_fund_app_fees_to_customer_orders()
    {
        $product_1 = factory(Product::class)->states('openlive')->create([
            'product_amount' => 2000, 'charge_app_fee' => true, 'app_fee_percent' => 2
        ]);

        $order_1 = $product_1->makePayment('brad@me.com');

        $this->assertEquals(2040, $order_1->total_amount);
        $this->assertEquals(2000, $order_1->product_amount);
        $this->assertEquals(2, $order_1->app_fee_percent);
        $this->assertTrue($order_1->charge_app_fee);

        // Second Fund with different variables
        $product_2 = factory(Product::class)->states('openlive')->create([
            'product_amount' => 3500, 'charge_app_fee' => true, 'app_fee_percent' => 4
        ]);

        $order_2 = $product_2->makePayment('karen@me.com');

        $this->assertEquals(3640, $order_2->total_amount);
        $this->assertEquals(3500, $order_2->product_amount);
        $this->assertEquals(4, $order_2->app_fee_percent);
        $this->assertTrue($order_2->charge_app_fee);

        // Third Fund with app fee not being charged
        $product_3 = factory(Product::class)->states('openlive')->create([
            'product_amount' => 5400, 'charge_app_fee' => false, 'app_fee_percent' => 4
        ]);

        $order_3 = $product_3->makePayment('karen@me.com');

        $this->assertEquals(5400, $order_3->total_amount);
        $this->assertEquals(5400, $order_3->product_amount);
        $this->assertEquals(4, $order_3->app_fee_percent);
        $this->assertFalse($order_3->charge_app_fee);
    }

}
