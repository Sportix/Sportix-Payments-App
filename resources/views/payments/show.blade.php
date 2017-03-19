@extends('layouts.payments')

@section('content')

    <div class="container-wall">
        <h2 class="text-center mt-10">{{ $product->total_due }}</h2>
        <h4 class="text-center mt-10">Due: {{ $product->formatted_due_date }}</h4>

        <div>
            {{ $product->payment_description }}
        </div>

        <stripe-checkout
            :price="">{{ $product->payment_amount }}</stripe-checkout>

    </div><!--/container-wall-->

@endsection
