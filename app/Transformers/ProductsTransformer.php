<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductsTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include with the data
     */
    protected $availableIncludes = [
        'orders'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id'                    => (int) $product->id,
            'account_id'            => (int) $product->account_id,
            'product_name'          => $product->product_name,
            'payment_amount'        => (int) $product->payment_amount,
            'is_fixed_payment'      => (boolean) $product->is_fixed_payment,
            'payment_description'   => $product->payment_description,
            'description'           => $product->description,
            'is_recurring'          => (boolean) $product->is_recurring,
            'recurring_interval'    => $product->recurring_interval,
            'due_date'              => convertDateForApi($product->due_date),
            'charge_app_fee'        => (boolean) $product->charge_app_fee,
            'app_fee_percent'       => (int) $product->app_fee_percent,
            'created_at'            => convertDateForApi($product->created_at),
            'updated_at'            => convertDateForApi($product->updated_at)
        ];
    }

    public function includeOrders(Product $product) {
        if($product->orders) {
            return $this->collection($product->orders, new OrdersTransformer);
        }
    }
}
