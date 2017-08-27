@extends('layouts.app')

@section('title', trans('home.index.title'))

@section('content')
    @if (auth()->check())
        @include('home._index_user')
    @else
        @include('home._index_guest')
    @endif
@endsection