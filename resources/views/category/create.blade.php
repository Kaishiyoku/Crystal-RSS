@extends('layouts.app')

@section('title', __('category.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('categories.create') !!}
@endsection

@section('content')
    <h1>{{ __('category.create.title') }}</h1>

    {{ Form::open(['route' => 'categories.store', 'method' => 'post', 'role' => 'form']) }}
        @include('category._form', ['submitTitle' => __('common.create')])
    {{ Form::close() }}
@endsection