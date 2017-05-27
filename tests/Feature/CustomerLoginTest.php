<?php

namespace Tests\Feature;

use Auth;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomerLoginTest extends TestCase
{
    /** @test */
    public function a_user_can_login_with_valid_credentials()
    {
        $user = factory(User::class)->create([
            'email' => 'john@smith.com',
            'password' => bcrypt('valid_password')
        ]);

        $response = $this->post('/login', [
            'email' => 'john@smith.com',
            'password' => 'valid_password'
        ]);

        $response->assertRedirect('/admin/dashboard');

        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = factory(User::class)->create([
            'email' => 'john@smith.com',
            'password' => bcrypt('valid_password')
        ]);

        $response = $this->post('/login', [
            'email' => 'john@smith.com',
            'password' => 'invalid_password'
        ]);

        //$response->assertRedirect('/login');
        //$response->assertSessionHasErrors('');

        $this->assertFalse(Auth::check());
    }


}
