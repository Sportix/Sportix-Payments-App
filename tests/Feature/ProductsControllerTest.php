<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsControllerTest extends TestCase {

    use DatabaseMigrations;
    use WithoutMiddleware;
    use DatabaseTransactions;

    /** @test */
    public function mandatory_fields_are_required_to_create_a_product()
    {
        // only a few form objects where filled
        $post_array = [
            '_token' => csrf_token(),
            'description' => 'some basic description'
        ];

        // Submit the form
        $response = $this->call('POST', '/products', $post_array);

        $this->assertResponseStatus(302);
        $this->assertHasOldInput();
    }

    /** @test */
//    public function creates_a_valid_product_with_all_required_fields()
//    {
//        $this->disableExceptionHandling();
//        // only a few form objects where filled
//        $post_array = [
//            '_token' => csrf_token(),
//            'fund_name' => 'test 123',
//            'fee_amount' => 1000,
//            'fee_description' => 'A Team Fund',
//            'description' => 'some basic description',
//            'has_installments' => 1,
//            'is_public' => 1,
//            'charge_app_fee' => 1,
//        ];
//
//        // Submit the form
//        $response = $this->call('POST', '/funds', $post_array);
//
//        $this->assertResponseStatus(200);
//        $this->assertRedirectedTo('/funds');
//    }
}
