@extends('layouts.app')

@section('content')

<section class="page-heading">
    <div class="container">
        <span class="page-heading-title">Dashboard</span>
        <span class="pull-right">
            <a href="/products/create" class="btn btn-success">Create A Payment</a>
        </span>         
    </div>
</section>

<!-- Container -->
<div class="container">
    <div class="row">
        <div class="col-lg-8">

            <div class="content-wrapper mt-25">
                <p>Here is some sample text</p>
            </div>

        </div><!--/col-lg-7-->

        <div class="col-lg-4">
            <div class="content-wrapper mt-25">
                <p>I am on the right</p>
            </div>
        </div><!--/col-lg-5-->

    </div><!--/row-->
</div><!--/container-->

@endsection
