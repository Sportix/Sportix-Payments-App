<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Accounts::class);
        $this->call(Products::class);
        $this->call(Orders::class);
    }
}
