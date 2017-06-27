<?php

namespace Tests\Feature;

use App\Order;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewOrderTest extends TestCase
{
    /** @test */
    public function a_user_can_make_a_payment_on_a_published_product()
    {
        $this->disableExceptionHandling();
        // Create a new product with a specific fee
        $product = factory(Product::class)->states('openlive')->create([
            'payment_amount' => 2000, 'charge_app_fee' => true, 'app_fee_percent' => 2
        ]);

        $order = factory(Order::class)->create([
            'product_id' => $product->id,
            'transaction_id' => 'OrderTrans123'
        ]);

        $response = $this->get("/orders/OrderTrans123");

        $response->assertStatus(200);
        $response->assertViewHas('order', function($viewOrder) use ($order) {
            return $order->id === $viewOrder->id;
        });
    }
}
