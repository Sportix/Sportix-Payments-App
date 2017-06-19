<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Product;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddProductTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_administrator_can_view_the_add_product_form()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/admin/payments/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function an_guest_cannot_view_the_add_product_form()
    {
        $response = $this->get('/admin/payments/create');

        $response->assertStatus(302);
    }

    /** @test */
    public function a_user_can_create_a_valid_product()
    {
        //$this->disableExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/admin/payments', [
            'account_id'            => $user->account_id,
            'created_by'            => $user->id,
            'product_name'          => 'Hockey Tourney',
            'payment_amount'        => 300.50,
            'is_fixed_payment'      => false,
            'payment_description'   => 'Please help us',
            'description'           => 'Here is a full description',
            'is_recurring'          => false,
            'recurring_interval'    => 1,
            'recurring_cycles'      => 1,
            'due_date'              => Carbon::now()->addDays(10),
            'charge_app_fee'        => false,
            'app_fee_percent'       => 4,
            'published_at'          => Carbon::now()
        ]);

        tap(Product::first(), function ($product) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/admin/payments/{$product->id}");

            $this->assertEquals('Hockey Tourney', $product->product_name);
            $this->assertEquals(30050, $product->payment_amount);
        });

    }

    /** @test */
    public function a_guest_user_cannot_a_product()
    {
        $response = $this->post('/admin/payments', [
            'account_id'            => 1,
            'created_by'            => 1,
            'product_name'          => 'Hockey Tourney',
            'payment_amount'        => 300.50,
            'is_fixed_payment'      => false,
            'payment_description'   => 'Please help us',
            'description'           => 'Here is a full description',
            'is_recurring'          => false,
            'recurring_interval'    => 1,
            'recurring_cycles'      => 1,
            'due_date'              => Carbon::now()->addDays(10),
            'charge_app_fee'        => false,
            'app_fee_percent'       => 4,
            'published_at'          => Carbon::now()
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertEquals(0, Product::count());
    }

    /** @test */
    public function a_product_name_is_required()
    {
        //$this->disableExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/admin/payments', [
            'account_id'            => $user->account_id,
            'created_by'            => $user->id,
            'product_name'          => 'Hockey Tourney',
            'payment_amount'        => 300.50,
            'is_fixed_payment'      => false,
            'payment_description'   => 'Please help us',
            'description'           => 'Here is a full description',
            'is_recurring'          => false,
            'recurring_interval'    => 1,
            'recurring_cycles'      => 1,
            'due_date'              => Carbon::now()->addDays(10),
            'charge_app_fee'        => false,
            'app_fee_percent'       => 4,
            'published_at'          => Carbon::now()
        ]);

        tap(Product::first(), function ($product) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/admin/payments/{$product->id}");

            $this->assertEquals('Hockey Tourney', $product->product_name);
            $this->assertEquals(30050, $product->payment_amount);
        });

    }

}
