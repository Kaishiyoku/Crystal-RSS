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
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

    @include('shared._favicon')

    @include('shared._javascript_config')
</head>
<body class="text-gray-700 tracking-wider">

@include('flash::message')

<div class="md:flex md:justify-between bg-gradient-to-r from-primary-900 to-secondary-900 h-48 md:h-32">
    <div class="text-white uppercase text-2xl pl-8 pt-4">
        {{ Html::link('/', config('app.name', 'Laravel')) }}
    </div>

    @if (Route::has('login'))
        <div class="pl-8 md:pl-0 pr-8 pt-20 md:pt-4">
            @guest
                {{ Html::linkRoute('login', __('common.nav.login'), null, ['class' => 'text-primary-300 hover:text-white uppercase pr-4 transition-all duration-200']) }}

                @if (Route::has('register'))
                    {{ Html::linkRoute('register', __('common.nav.register'), null, ['class' => 'text-primary-300 hover:text-white uppercase pl-4 transition-all duration-200']) }}
                @endif
            @endauth
        </div>
    @endif
</div>

<div class="container mx-auto text-center mt-40">
    @yield('content')
</div>

</body>
</html>
