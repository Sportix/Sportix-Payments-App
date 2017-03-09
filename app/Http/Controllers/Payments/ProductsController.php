<?php

namespace App\Http\Controllers\Payments;

use App\Product;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function show($id)
    {
        $product = Product::published()->findOrFail($id);

        return view('payments.show', ['product' => $product]);
    }

}
