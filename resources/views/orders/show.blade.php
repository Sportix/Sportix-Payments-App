@extends('layouts.payments')

@section('content')

    <div class="m-xs-auto">
        <div class="m-xs-b-6">
            <div class="flex-baseline flex-spaced p-xs-y-4 border-b">
                <h1 class="text-xl">Order Summary</h1>
                <a href="{{ url("/orders/confirmNumber") }}" class="link-brand-soft">confirmNumber</a>
            </div>
        </div>
    </div>

    <div class="bg-soft p-xl-b-2">
        <div class="container">
            <div class="constrain-xl m-xs-auto">
                <div class="p-xs-y-4 border-b">
                    <p>
                        <strong>Order Total: $100.00</strong>
                    </p>
                    <p class="text-dark-soft">Billed to Card #: **** **** **** 1234</p>
                </div>

                <div class="m-xs-b-7">
                    <h2 class="text-lg wt-normal m-xs-b-4">ProductName</h2>


                </div>
            </div><!--/constrain-->
        </div><!--/container-->

    </div><!--/bg-soft-->

@endsection

@push('beforeScripts')

@endpush
