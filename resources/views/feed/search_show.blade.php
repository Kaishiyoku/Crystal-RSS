@extends('layouts.app')

@section('title', trans('feed.search_show.title'))

@section('content')
    <h1>{{ trans('feed.search_show.title') }}</h1>

    @include('feed._search_form')
@endsection