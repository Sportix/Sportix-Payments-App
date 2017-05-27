<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CustomerLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(User::class)->create([
            'email' => 'john@smith.com',
            'password' => bcrypt('valid_password')
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'valid_password')
                    ->press('Sign in')
                    ->assertPathIs('/admin/dashboard');
        });
    }

    /** @test */
    // public function a_user_cannot_login_with_bad_credentials()
    // {
    //     $user = factory(User::class)->create([
    //         'email' => 'john@smith.com',
    //         'password' => bcrypt('valid_password')
    //     ]);
    //
    //     $this->browse(function (Browser $browser) use($user) {
    //         $browser->visit('/login')
    //                 ->type('email', $user->email)
    //                 ->type('password', 'invalid_password')
    //                 ->press('Sign in')
    //                 ->assertSee('Invalid');
    //     });
    // }
}
