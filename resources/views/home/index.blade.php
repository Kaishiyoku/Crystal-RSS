@extends('layouts.app')

@section('title', trans('home.index.title'))

@section('content')
    <div class="d-flex justify-content-center">
        <img src="{{ asset('img/logo.svg') }}" class="logo"/>
    </div>

    <div class="d-flex justify-content-center mb-5">
        <img src="{{ asset('img/lettering.svg') }}" class="lettering img-fluid"/>
    </div>

    @include('shared._login')
@endsection