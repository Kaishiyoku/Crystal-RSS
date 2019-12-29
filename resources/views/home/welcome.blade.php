@extends('layouts.app_welcome')

@section('content')
    <div class="content">
        <img src="{{ asset('img/logo.svg') }}" class="logo-sm"/>

        <div class="title pb-3">
            {{ config('app.name', 'Laravel') }}
        </div>

        <div class="links">
            v{{ env('VERSION_NUMBER') }}
            {{ Html::link('https://github.com/kaishiyoku/Crystal-RSS', 'GitHub') }}
            {{ Html::linkRoute('home.imprint', __('common.nav.imprint')) }}
            {{ Html::linkRoute('home.contact', __('common.nav.contact')) }}
        </div>
    </div>
@endsection
