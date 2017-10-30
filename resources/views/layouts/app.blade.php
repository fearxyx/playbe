<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('title')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Paybe.cz') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header>
            @include('partials.header')
        </header>

        @yield('content')
        <footer class="col-md-12 clearfix">
            @include('partials.footer')
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    @include('modals.podmienky')
    @include('modals.kontakt')
</body>
</html>
