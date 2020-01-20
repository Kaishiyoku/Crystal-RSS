<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="welcome">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @include('shared._favicon')

    @include('shared._javascript_config')
</head>
<body class="welcome">

@include('flash::message')

<div class="flex-center position-ref full-height">
    <div class="top-left brands d-none d-sm-inline">
        {{ Html::link('/', config('app.name', 'Laravel')) }}
    </div>

    @if (Route::has('login'))
        <div class="top-right links links-nav">
            @auth
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                {{ Html::linkRoute('login', __('common.nav.login')) }}

                @if (Route::has('register'))
                    {{ Html::linkRoute('register', __('common.nav.register')) }}
                @endif
            @endauth
        </div>
    @endif

    @yield('content')
</div>

</body>
</html>
