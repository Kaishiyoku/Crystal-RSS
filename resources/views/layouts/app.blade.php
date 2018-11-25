<!DOCTYPE html>
<html lang="en">
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
    {{ Html::style('js/plugins/codesample/css/prism.css') }}

    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

    @include('shared._javascript_config')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary z-m-b-25">
        <div class="container">
            <a class="navbar-brand" href="{{ URL::route('home.index') }}">
                <img src="{{ asset('img/logo_small.png') }}" height="30" class="d-inline-block align-top mr-1"/>
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! Menu::render() !!}

                <ul class="navbar-nav">
                    @include('shared._navbar_language_dropdown')
                </ul>

                {!! Menu::render('user') !!}

                @auth
                    @include('shared._logout_form')
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        @include('flash::message')

        @yield('breadcrumbs')

        @yield('content')
    </div>

    <div class="container">
        @include('shared._footer')
    </div>
</div>

{{ Html::script('js/app.js') }}

@yield('scripts')

</body>
</html>
