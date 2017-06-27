<?php

namespace App\Http\Controllers\Payments;

use App\Order;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function show($transactionId)
    {
        $order = Order::findByTransactionId($transactionId);

        return view('orders.show', ['order' => $order]);
    }
}
