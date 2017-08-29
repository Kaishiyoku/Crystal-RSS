@extends('layouts.app')

@section('title', trans('category.edit.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('categories.edit', $category) !!}
@endsection

@section('content')
    <h1>{{ trans('category.edit.title', ['title' => $category->title]) }}</h1>

    {{ Form::open(['route' => ['categories.update', $category->id], 'method' => 'put', 'role' => 'form']) }}
        @include('category._form', ['submitTitle' => trans('common.update')])
    {{ Form::close() }}
@endsection