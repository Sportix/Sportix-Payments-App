@extends('layouts.payments')

@section('content')

    <div class="container-wall">
        <h5 class="text-center">{{ $product->total_due }}</h5>
        <h6 class="text-center">{{ $product->formatted_due_date }}</h6>

        <div>
            {{ $product->product_description }}
        </div>

        <button class="mt-10 btn btn-lg btn-primary btn-block" type="submit">PAY NOW</button>

    </div><!--/container-wall-->

@endsection
