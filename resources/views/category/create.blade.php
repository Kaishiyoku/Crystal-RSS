@extends('layouts.app')

@section('title', trans('category.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('categories.create') !!}
@endsection

@section('content')
    <h1>{{ trans('category.create.title') }}</h1>

    {{ Form::open(['route' => 'categories.store', 'method' => 'post', 'role' => 'form']) }}
        @include('category._form', ['submitTitle' => trans('common.create')])
    {{ Form::close() }}
@endsection