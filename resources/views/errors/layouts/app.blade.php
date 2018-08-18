<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('shared._favicon')

    {{ Html::style('css/app.css') }}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary m-b-25">
            <div class="container">
                {{ Html::linkRoute('home.index', config('app.name', 'Laravel'), [], ['class' => 'navbar-brand']) }}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        <div class="container mt-5">
            @yield('content')

            @include('shared._footer')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
