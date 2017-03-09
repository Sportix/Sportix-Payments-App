<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Product;
use Carbon\Carbon;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;

class ViewProductListingTest extends TestCase
{
    /** @group viewTest */
    function test_user_can_view_a_published_product_listing()
    {
        // Arrange
        $product = factory(Product::class)->states('published')->create([
            'payment_amount' => 3500, 'due_date'=> Carbon::parse('+1 week')
        ]);

        // Act
        $response = $this->get('/p/' . $product->id);

        // Assert
        $response->assertSee($product->product_name);
        $response->assertSee($product->formatted_due_date);
        $response->assertSee('$35.00');
        $response->assertSee($product->payment_description);
    }

    /** @group viewTest */
    public function test_user_cannot_view_unpublished_products()
    {
        $product = factory(Product::class)->states('unpublished')->create();

        $response = $this->get('/p/' . $product->id);

        $response->assertStatus(404);
    }

    /** @group viewTest */
//    public function test_user_cannot_see_payment_button_product_past_due_date()
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
