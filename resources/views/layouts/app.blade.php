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
    {{ Html::style('css/fonts.css') }}

    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>

    {{ Html::script('js/app.js') }}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js" charset="utf-8"></script>

    @include('shared._javascript_config')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom z-m-b-25">
        <div class="container">
            <a class="navbar-brand" href="{{ URL::route('home.index') }}">
                <img src="{{ asset('img/logo_small.png') }}" height="30" class="d-inline-block align-top mr-1"/>
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! \LaravelMenu::render() !!}

                <ul class="navbar-nav">
                    @include('shared._navbar_language_dropdown')
                </ul>

                {!! \LaravelMenu::render('user') !!}
            </div>
        </div>
    </nav>

    <div class="container mx-auto">
        @include('flash::message')

        @yield('breadcrumbs')
        @yield('content')
    </div>

    <div class="container">
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
