<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Euro 2020">
    <meta name="author" content="Bladabli">
    <meta name="keywords" content="Euro 2020">
    <title>{{ config('app.name')}}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon/football-soccer-ball-144-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('images/favicon/football-soccer-ball-152-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/favicon/football-soccer-ball-144-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('images/favicon/football-soccer-ball-120-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/favicon/football-soccer-ball-114-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/favicon/football-soccer-ball-72-183228.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon/football-soccer-ball-57-183228.png') }}">
    <link rel="icon" href="{{ asset('images/favicon/football-soccer-ball-32-183228.png') }}" sizes="32x32">
    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'user' => Auth::user()
        ]) !!};
    </script>
    @yield('head')
</head>
<body style="background: #a6a2a3;">
    <div id="app">

        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
