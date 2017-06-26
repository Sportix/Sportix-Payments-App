<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\OrdersTransformer;

class OrdersController extends Controller
{
    public function index($accountId)
    {
        $orders = Order::with('product')
                    ->where('account_id', '=', $accountId)
                    ->orderBy('created_at', 'DESC')
                    ->get();

        return fractal($orders, new OrdersTransformer())->respond(200);
    }

    public function show($id)
    {
        $order = Order::with('product')
                    ->where('id', $id)
                    ->first();

        return fractal($order, new OrdersTransformer())->respond(200);
    }
}
