<?php

use Illuminate\Database\Seeder;

class Accounts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Account::class, 4)->create();

        // Create myself
        $user = App\User::create([
            'name'      => 'Brad Madigan',
            'email'     => 'bradmadigan@gmail.com',
            'current_account_id' => 1,
            'password'  => bcrypt('password')
        ]);

        // Make myself the owner of Account 1
        $account  = App\Account::find(1);
        $account->owner_id = $user->id;
        $account->save();
    }
}
