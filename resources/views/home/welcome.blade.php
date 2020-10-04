@extends('layouts.app_welcome')

@section('content')
    <div>
        <img src="{{ asset('img/logo.svg') }}" class="h-40 mx-auto" alt="Logo"/>

        <div class="text-8xl font-light">
            {{ config('app.name', 'Laravel') }}
        </div>

        <div class="pt-8">
            <span class="pl-2 pr-2">v{{ env('VERSION_NUMBER') }}</span>
            {{ Html::link('https://github.com/kaishiyoku/Crystal-RSS', 'GitHub', ['class' => 'text-primary-900 hover:text-black uppercase pl-2 pr-2 transition-all duration-200']) }}
            {{ Html::linkRoute('home.imprint', __('common.nav.imprint'), null, ['class' => 'text-primary-900 hover:text-black uppercase pl-2 pr-2 transition-all duration-200']) }}
            {{ Html::linkRoute('home.contact', __('common.nav.contact'), null, ['class' => 'text-primary-900 hover:text-black uppercase pl-2 pr-2 transition-all duration-200']) }}
        </div>
    </div>
@endsection
