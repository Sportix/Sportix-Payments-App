<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Account;
use App\Product;
use App\Order;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewOrdersTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
    }

    public function an_administrator_can_view_the_orders_dashboard_page()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(200);
    }


    public function a_guest_cannot_view_the_dashboard_orders_page()
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(302);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function the_orders_api_only_displays_associated_account_orders()
    {
        // Accounts setup
        $accountA = factory(Account::class)->create();
        $accountB = factory(Account::class)->create();
        // Users setup
        $userA = $accountA->owner;
        $userB = $accountB->owner;

        // Products setup
        $productA = factory(Product::class)->states('openlive')->create(['account_id' => $accountA->id]);
        $productA2 = factory(Product::class)->states('openlive')->create(['account_id' => $accountA->id]);
        $productB = factory(Product::class)->states('openlive')->create(['account_id' => $accountB->id]);

        // Orders setup
        $orderA = factory(Order::class)->create([
            'product_id' => $productA->id,
            'account_id' => $productA->account_id
        ]);  // valid orders
        $orderA2 = factory(Order::class)->create([
            'product_id' => $productA2->id,
            'account_id' => $productA->account_id
        ]); // valid orders
        $orderB = factory(Order::class)->create([
            'product_id' => $productB->id,
            'account_id' => $productB->account_id
        ]);  // in-valid orders

        $response = $this->json('GET', '/api/v1/orders/all/' . $accountA->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $orderA->id,
                'transaction_id' => $orderA->transaction_id
            ])
            ->assertJsonFragment([
                'id' => $orderA2->id,
                'transaction_id' => $orderA2->transaction_id
            ])
            ->assertJsonMissing([
                'transaction_id' => $orderB->transaction_id
            ]);
    }

    /** @test */
    public function the_orders_api_will_return_a_valid_account_order()
    {
        // Accounts setup
        $accountA = factory(Account::class)->create();
        $userA = $accountA->owner;

        // Products setup
        $productA = factory(Product::class)->states('openlive')->create(['account_id' => $accountA->id]);
        
        // Orders setup
        $orderA = factory(Order::class)->create([
            'product_id' => $productA->id,
            'account_id' => $productA->account_id
        ]);  // valid orders

        $response = $this->json('GET', '/api/v1/orders/all/' . $accountA->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $orderA->id,
                'transaction_id' => $orderA->transaction_id
            ])
            ->assertJsonFragment([
                'id' => $orderA2->id,
                'transaction_id' => $orderA2->transaction_id
            ])
            ->assertJsonMissing([
                'transaction_id' => $orderB->transaction_id
            ]);
    }

}
