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
    function user_can_view_a_published_product_listing()
    {
        // Arrange
        $product = factory(Product::class)->states('published')->create([
            'fee_amount' => 3500, 'due_date'=> Carbon::parse('January 8, 2016')
        ]);

        // Act
        $this->visit('/p/' . $product->id);

        // Assert
        $this->see($product->product_name);
        $this->see('January 8, 2016');
        $this->see('$35.00');
        $this->see($product->fee_description);
    }

    /** @test */
    public function user_cannot_view_unpublished_products()
    {
        $product = factory(Product::class)->states('unpublished')->create();

        $this->get('/p/' . $product->id);

        $this->assertResponseStatus(404);
    }

    /** @test */
    public function user_cannot_see_payment_button_product_past_due_date()
    {
        $product = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('January 8, 2015')
        ]);

        $this->visit('/p/' . $product->id);

        $this->see('Past Due Date');
    }
}
