<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JS тест | @yield('title')</title>

    <!-- Scripts -->

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="@yield('test-bg')">
    <div class="content-wrapper">
    <div class="@yield('logo')"></div>
        <div class="content">
            @yield('content')
        </div>
    </div>
</body>
</html>
