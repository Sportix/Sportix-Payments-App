@extends('layouts.payments')

@section('content')

    <div class="container-wall">
        <h2 class="text-center mt-10">{{ $product->total_due }}</h2>
        <h4 class="text-center mt-10">Due: {{ $product->formatted_due_date }}</h4>

        <div class="text-center mt-20">
            {{ $product->payment_description }}
        </div>

        <stripe-checkout
            :price="{{ $product->payment_amount }}"
            product-name="{{ $product->product_name }}"
            :product-id="{{ $product->id }}">
        </stripe-checkout>

    </div><!--/container-wall-->

@endsection

@push('beforeScripts')
    <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
