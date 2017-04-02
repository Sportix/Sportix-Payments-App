<?php

namespace App\Http\Controllers\Payments;

use App\Product;
use App\Http\Requests;
use App\Billing\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Billing\PaymentFailedException;
use App\Exceptions\PastDueDateException;

class ProductOrdersController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store($productId)
    {
        $product = Product::published()->findOrFail($productId);

        $this->validate(request(), [
            'email' => ['required', 'email'],
            'payment_token' => ['required']
        ]);

        try {
            $order = $product->makePayment(request('email'));

            $this->paymentGateway->charge($order->total_amount, request('payment_token'));
            //$order->updateFromStripe($charge);

            return response()->json($order, 201);
        } catch(PaymentFailedException $e) {
            $order->cancel();
            return response()->json([], 422);
        } catch(PastDueDateException $e) {
            return response()->json([], 422);
        }

    }
}
