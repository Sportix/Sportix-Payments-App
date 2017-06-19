<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store()
    {
        $product = Product::create([
            'account_id'            => Auth::user()->current_account_id,
            'created_by'            => Auth::user()->id,
            'product_name'          => request('product_name'),
            'payment_amount'        => request('payment_amount') * 100,
            'is_fixed_payment'      => request('is_fixed_payment'),
            'payment_description'   => request('payment_description'),
            'description'           => request('description'),
            'is_recurring'          => request('is_recurring'),
            'recurring_interval'    => request('recurring_interval'),
            'recurring_cycles'      => request('recurring_cycles'),
            'due_date'              => request('due_date'),
            'charge_app_fee'        => request('charge_app_fee'),
            'app_fee_percent'       => 4,
            'published_at'          => request('published_at')
        ]);

        return redirect("/admin/payments/{$product->id}");
    }

    public function edit(Request $request, $id)
    {
        return view('admin.products.edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
