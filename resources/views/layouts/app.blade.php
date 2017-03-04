<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', config('app.name'))</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="/css/app.css" rel="stylesheet">

    	{{-- custom scripts --}}
    	@yield('scripts', '')

	</head>
	<body class="app-body">

        {{-- App-Level Navigation --}}
        @include('partials.app_navigation')

        {{-- Main Content --}}
        @yield('content')
		
        {{-- App Footer --}}
        @include('partials.app_footer')

    {{-- Javascript --}}
    <script src="/js/app.js"></script>
	</body>
</html>