<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .backgroundLogin {
            background-image: url('/storage/images/ramenLogin.svg');
            background-color: #cccccc;
            height: 100vh;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .backgroundRegister {
            background-image: url('/storage/images/registerLogin.svg');
            background-color: #cccccc;
            height: 100vh;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        body {
            height: 100%;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class=""></div>
        <main class="">
            @yield('content')
        </main>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
@yield('js_after')

</html>
