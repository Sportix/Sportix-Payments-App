<?php

use Illuminate\Database\Seeder;

class Orders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = App\Product::all();
        $name = ['Steve', 'Mary', 'Owen', 'Rick', 'Nemo', 'Tim', 'Ally', 'Brian', 'Borris', 'Les', 'Connor', 'Karen'];

        foreach($products as $product)  {
            if( ! $product->isPastDue()) {
                $i = 0;
                while($i < rand(1, 6)) {
                    $product->makePayment('my-' . rand(1, 9999) . '-email@email.com');
                    $i++;
                }
            }
        }
    }
}
