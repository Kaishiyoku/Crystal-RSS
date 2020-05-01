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

    @include('shared._javascript_config')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark m-b-25">
        <div class="container">
            {{ Html::linkRoute('admin.home.index', config('app.name', 'Laravel') . ' - ' . __('common.nav.administration'), [], ['class' => 'navbar-brand']) }}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! Menu::render('administration') !!}

                {!! Menu::render('administration-user') !!}
            </div>
        </div>
    </nav>

    <div class="container">
        @include('flash::message')

        @yield('breadcrumbs')

        @yield('content')

        @include('shared._footer')
    </div>
</div>

@include('shared._logout_form')

{{ Html::script('js/app.js') }}
{{ Html::script('js/dist.js') }}

@yield('scripts')

<script type="text/javascript">
    const logoutAnchor = document.querySelector('a[href$="{{ url()->route('logout') }}"]');

    logoutAnchor.addEventListener('click', function (event) {
        event.preventDefault();

        document.querySelector('#logout-form').submit();
    });
</script>

</body>
</html>
