<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Laravel') }}
        -
        @yield('title')
    </title>

    @include('shared._favicon')

    {{ Html::style('css/app.css') }}
    {{ Html::style('css/additions.css') }}
    {{ Html::style('css/fonts.css') }}

    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

    {{ Html::script('js/app.js') }}

    @include('shared._javascript_config')
</head>
<body class="bg-gray-100">
<div id="app">
    <div class="mb-6 bg-gradient-to-r from-primary-900 to-secondary-900 shadow">
        <div class="container lg:px-20 mx-auto">
            <div class="md:flex md:items-center">
                <div class="flex items-center pt-3 md:pt-0">
                    <img src="{{ asset('img/logo_small.png') }}" class="h-8 pl-2 lg:pl-0 mr-2" alt="Logo"/>
                    <div class="text-white text-xl mr-2"><a href="{{ URL::route('home.index') }}">{{ config('app.name', 'Laravel') }}</a></div>
                </div>

                <div class="flex flex-grow justify-between">
                    {!! \LaravelMenu::render() !!}

                    <div class="flex">
                        @include('shared._navbar_language_dropdown')

                        {!! \LaravelMenu::render('user') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container px-4 lg:px-20 mx-auto">
        @include('flash::message')

        @yield('breadcrumbs')
        @yield('content')
    </div>

    <div class="container lg:px-20 mx-auto mt-20 text-gray-600 text-sm">
        @include('shared._footer')
    </div>
</div>

@include('shared._logout_form')

@yield('scripts')

<script type="text/javascript">
    window.TRANSLATIONS = {!! json_encode(__('javascript')) !!}

    const logoutAnchor = document.querySelector('a[href$="{{ url()->route('logout') }}"]');

    logoutAnchor.addEventListener('click', function (event) {
        event.preventDefault();

        document.querySelector('#logout-form').submit();
    });
</script>

</body>
</html>
