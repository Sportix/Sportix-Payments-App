<?php

namespace App\Transformers;

use App\Order;
use App\Product;
use League\Fractal\TransformerAbstract;

class OrdersTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include with the data
     */
    protected $defaultIncludes = [
        'product'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Order $order)
    {
        return [
            'id'                    => (int) $order->id,
            'account_id'            => (int) $order->account_id,
            'transaction_id'        => $order->transaction_id,
            'product_id'            => (int) $order->product_id,
            'product_type'          => $order->product_type,
            'payment_amount'        => (int) $order->payment_amount,
            'app_fee_percent'       => (int) $order->app_fee_percent,
            'charge_app_fee'        => (boolean) $order->charge_app_fee,
            'total_app_fee_charged' => (int) 0, // $order->appFee(),
            'created_at'            => convertDateForApi($order->created_at),
            'updated_at'            => convertDateForApi($order->updated_at)
        ];
    }

    /**
     * Include Category
     */
    public function includeProduct(Order $order)
    {
        $product = $order->product;

        return $this->item($product, new ProductsTransformer);
    }
}
