@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">

                <h1 class="text-center login-title">Sign in to Sportix</h1>

                <div class="container-wall">
                    <img class="profile-img" src="https://sportix.io/fluid-icon-512.png"
                         alt="">
                    <form class="form-signin" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            @if ($errors->has('email'))
                                <span class="help-block">Invalid email or password</span>
                            @endif
                        </div>

                        <input type="text" class="form-control" placeholder="Email" required autofocus>
                        <input type="password" class="form-control" placeholder="Password" required>

                        <button class="mt-25 mb-25 btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>
                        <label class="checkbox ml-25 pull-left">
                            <input type="checkbox" value="remember-me">
                            Remember me
                        </label>
                    </form>
                </div>

                <a href="#" class="text-center new-account">Create an account </a>
            </div><!--/col-sm-6-->
        </div><!--/row-->
    </div><!--/container-->

@endsection

@push('beforeScripts')
<script src="https://checkout.stripe.com/checkout.js"></script>
@endpush
