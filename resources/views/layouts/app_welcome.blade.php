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

<div class="pb-40">
    <div class="absolute w-full bg-gradient-to-r md:bg-none from-primary-900 to-secondary-900">
        <div class="md:flex md:justify-between">
            <div class="text-white uppercase text-2xl pl-8 pt-4">
                {{ Html::link('/', config('app.name', 'Laravel')) }}
            </div>

            @if (Route::has('login'))
                <div class="pl-8 md:pl-0 pr-8 pt-4">
                    @guest
                        {{ Html::linkRoute('login', __('common.nav.login'), null, ['class' => 'text-primary-300 hover:text-white uppercase pr-4 transition-all duration-200']) }}

                        @if (Route::has('register'))
                            {{ Html::linkRoute('register', __('common.nav.register'), null, ['class' => 'text-primary-300 hover:text-white uppercase pl-4 transition-all duration-200']) }}
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="absolute mt-20 md:mt-0" style="z-index: -1;">
        <defs>
            <linearGradient id="pathGradient" x1="0" y1="0.5" x2="1" y2="0.5">
                <stop offset="0" stop-color="#6927ff"/>
                <stop offset="1" stop-color="#914cd9"/>
            </linearGradient>
        </defs>
        <path fill="url(#pathGradient)" fill-opacity="1" d="M0,224L60,192C120,160,240,96,360,101.3C480,107,600,181,720,192C840,203,960,149,1080,128C1200,107,1320,117,1380,122.7L1440,128L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
    </svg>
</div>

<div class="container mx-auto text-center mt-40">
    <div class="mx-4 md:mx-8 py-8">
        @yield('content')
    </div>
</div>

</body>
</html>
