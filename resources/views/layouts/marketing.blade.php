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

    	<!-- Scripts -->
    	@yield('scripts', '')

	</head>
	<body>

        <h3 class="text-center mb-20">Marketing Layout</h3>

        <!-- Main Content -->
        @yield('content')
		
    <!-- JavaScript -->
    <script src="/js/app.js"></script>
	</body>
</html>