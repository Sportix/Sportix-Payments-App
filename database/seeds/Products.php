<?php

use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = \App\Account::all();

        foreach($accounts as $account)  {
            $funds = factory(App\Product::class, 2)->create([
                'account_id' => $account->id,
                'published_at' => Carbon\Carbon::parse('-1 week'),
                'due_date' => Carbon\Carbon::parse('+4 week')
            ]);
        }
    }
}
