@extends('layouts.app')

@section('title', __('feed.search_show.title'))

@section('content')
    <h1>{{ __('feed.search_show.title') }}</h1>

    @include('feed._search_form')
@endsection