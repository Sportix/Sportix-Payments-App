@extends('layouts.payments')

@section('content')

    <div class="container-wall">

        <div class="product-masthead">
            <h1 class="text-center product-title">{{ $product->product_name }}</h1>
        </div>

        <div class="text-center mt-20">
            Payment Info
        </div>

    </div><!--/container-wall-->

@endsection

@push('beforeScripts')

@endpush
