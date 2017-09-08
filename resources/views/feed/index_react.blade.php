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

    @include('shared._javascript_config')
</head>
<body>
<div id="app">

</div>

{{ Html::script('js/react/app.js') }}

@yield('scripts')

</body>
</html>
