<?php

namespace Tests;

use Tests\Support\DatabaseSetup;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    use DatabaseSetup;
    use CreatesApplication;

    protected $baseUrl = 'http://sportix-payments.dev';


    protected function setUp()
    {
        parent::setUp();
        $this->setupDatabase();
    }

    protected function assertResponseStatus($status)
    {
        $this->response->assertStatus($status);
    }

    protected function seeJsonSubset($data)
    {
        $this->response->assertJson($data);
    }

    protected function decodeResponseJson()
    {
        return $this->response->decodeResponseJson();
    }

    // protected function disableExceptionHandling()
    // {
    //     $this->app->instance(ExceptionHandler::class, new class extends Handler {
    //         public function __construct() {}
    //         public function report(Exception $e) {}
    //         public function render($request, Exception $e) {
    //             throw $e;
    //         }
    //     });
    // }

    // FORM HTML: <input name="order_numbers[]">
    // allows: $this->visit('/orders')
    //              ->storeArrayInput(['123'], 'order_numbers');
    protected function storeArrayInput($values, $name)
    {
        $this->inputs[$name] = $values;
        return $this;
    }
}
