<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use App\Order;
use Carbon\Carbon;
use App\Exceptions\PastDueDateException;

class ProductTest extends TestCase
{
    /** @test */
    public function it_can_get_a_formatted_date()
    {
        $product = factory(Product::class)->make([
            'due_date' => Carbon::parse('2016-08-01 6:00pm')
        ]);

        $this->assertEquals('August 1, 2016', $product->formatted_due_date);
    }

    /** @test */
    public function it_can_get_payment_amount_in_dollars()
    {
        $product = factory(Product::class)->make([
            'payment_amount' => 2088
        ]);

        $this->assertEquals('$20.88', $product->total_due);
    }

    /** @test */
    public function funds_with_a_published_at_date_are_published()
    {
        $publishedFundA = factory(Product::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedFundB = factory(Product::class)->create(['published_at' => Carbon::parse('-1 day')]);
        $unPublishedFund = factory(Product::class)->create(['published_at' => null]);

        $publishedFunds = Product::published()->get();

        $this->assertTrue($publishedFunds->contains($publishedFundA));
        $this->assertTrue($publishedFunds->contains($publishedFundB));
        $this->assertFalse($publishedFunds->contains($unPublishedFund));
    }

    /** @test */
    public function it_returns_true_if_past_due_date()
    {
        $product = factory(Product::class)->states('published')->create(['due_date' => Carbon::parse('-1 week')]);

        $this->assertTrue($product->isPastDue());
    }

    /** @test */
    public function it_gets_total_revenue_amount()
    {
        // A fund where we are charging the customer
        $product_1 = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('+1 week'),
            'payment_amount' => 2500,
            'charge_app_fee' => true,
            'app_fee_percent' => 10
        ]);

        // A fund where we are NOT charging the customer
        $product_2 = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('+1 week'),
            'payment_amount' => 2500,
            'charge_app_fee' => false
        ]);

        $order_1a = $product_1->makePayment('karen@me.com');
        $order_1b = $product_1->makePayment('brad@me.com');
        $order_1c = $product_1->makePayment('keely@me.com');

        $order_2a = $product_2->makePayment('karen@me.com');
        $order_2b = $product_2->makePayment('brad@me.com');
        $order_2c = $product_2->makePayment('keely@me.com');

        $this->assertEquals(8250, $product_1->getTotalRevenue()); // charged to customer
        $this->assertEquals(7500, $product_2->getTotalRevenue()); // not charged to customer
    }

    /** @test */
    public function it_can_make_a_payment()
    {
        $product = factory(Product::class)->states('published')->create([
            'payment_amount' => 2500, 'due_date' => Carbon::parse('+1 week'), 'charge_app_fee' => false
        ]);

        $order = $product->makePayment('brad@me.com');

        $this->assertEquals('brad@me.com', $order->email);
        $this->assertEquals(2500, $order->total_amount);
        $this->assertEquals($product->id, $order->product_id);
        $this->assertEquals('FUND', $order->product_type);
    }

    /** @test */
    public function trying_to_make_a_payment_after_due_date_throws_an_exception()
    {
        //$this->disableExceptionHandling();
        $product = factory(Product::class)->states('published')->create([
            'due_date' => Carbon::parse('-1 week')
        ]);

        try {
            $product->makePayment('brad@me.com');
        } catch (PastDueDateException $e) {
            // Make sure there are no orders
            $order = $product->orders()
                ->where('product_id', $product->id)
                ->where('product_type', 'FUND')
                ->where('email', 'brad@me.com')
                ->first();
            $this->assertNull($order);

            return;
        }

        $this->fail('Payment was made even though the Product is past due date');
    }
}
