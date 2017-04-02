<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/payments.css" rel="stylesheet">
@include('scripts.app')

<!-- Scripts -->
    @yield('scripts', '')

</head>
<body class="payment-body">

<!-- Main Content -->
@yield('content')

<!-- JavaScript -->
@stack('beforeScripts')
<script src="/js/app.js"></script>
@stack('afterScripts')
</body>
</html>
