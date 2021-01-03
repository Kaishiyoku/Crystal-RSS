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
<body class="bg-gray-50 bg-opacity-25 antialiased">
<div id="app">
    <div class="bg-white shadow">
        <div class="container lg:px-20 mx-auto">
            <div class="lg:flex lg:items-center">
                <div class="flex justify-between items-center">
                    <div class="text-xl mr-2 ml-2 md:ml-0 py-4">
                        <a href="{{ URL::route('home.index') }}" class="text-white lg:text-gray-700 transition-all duration-200 hover:text-black">
                            <span class="text-gradient bg-gradient-to-r from-primary-900 via-success-900 to-info-900">
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                    </div>

                    <button class="lg:hidden py-4 px-6 text-xl transition-all duration-200 text-white text-opacity-50 hover:text-white hover:bg-pink-900 hover:bg-opacity-25" data-navbar-control>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>

                <div class="flex flex-grow flex-col lg:flex-row lg:justify-between transition-all duration-500 hidden overflow-hidden" data-navbar-content>
                    <div>
                        {!! \LaravelMenu::render() !!}
                    </div>

                    <div class="flex flex-col lg:flex-row">
                        @include('shared._navbar_language_dropdown')

                        {!! \LaravelMenu::render('user') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-8 px-4 lg:px-20 mx-auto">
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
