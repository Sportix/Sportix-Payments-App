<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Product;
use Carbon\Carbon;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;

class ViewProductListingTest extends TestCase
{
    /** @test */
//    function user_can_view_a_published_product_listing()
//    {
//        // Arrange
//        $product = factory(Product::class)->states('published')->create([
//            'payment_amount' => 3500, 'due_date'=> Carbon::parse('January 8, 2016')
//        ]);
//
//        // Act
//        $response = $this->get('/p/' . $product->id);
//
//        // Assert
//        $response->assertSee($product->product_name);
//        $response->assertSee('January 8, 2016');
//        $response->assertSee('$35.00');
//        $response->assertSee($product->payment_description);
//    }

    /** @test */
//    public function user_cannot_view_unpublished_products()
//    {
//        $product = factory(Product::class)->states('unpublished')->create();
//
//        $response = $this->get('/p/' . $product->id);
//
//        $this->assertStatus(404);
//    }

    /** @test */
//    public function user_cannot_see_payment_button_product_past_due_date()
//    {
//        $product = factory(Product::class)->states('published')->create([
//            'due_date' => Carbon::parse('January 8, 2015')
//        ]);
//
//        $response = $this->get('/p/' . $product->id);
//
//        $response->assertSee('Past Due Date');
//    }
}
