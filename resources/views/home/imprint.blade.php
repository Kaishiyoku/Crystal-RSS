@extends('layouts.app')

@section('title', __('home.imprint.title'))

@section('content')
    <div class="container">
        <h1>{{ __('home.imprint.title') }}</h1>

        <address>
            <strong>{{ __('home.imprint.name') }}</strong><br/>
            {{ __('home.imprint.city') }}<br/>
            {{ __('home.imprint.street') }}<br/>
            {{ __('home.imprint.country') }}<br/>
            {{ __('home.imprint.email') }}
        </address>

        <h2>{{ __('home.imprint.disclaimer.title') }}</h2>

        {!! __('home.imprint.disclaimer.text') !!}
    </div>
@endsection
