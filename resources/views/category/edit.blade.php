@extends('layouts.app')

@section('title', __('category.edit.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('categories.edit', $category) !!}
@endsection

@section('content')
    <h1>@lang('category.edit.title', ['title' => $category->title])</h1>

    {{ Form::open(['route' => ['categories.update', $category->id], 'method' => 'put', 'role' => 'form']) }}
        @include('category._form', ['submitTitle' => __('common.update')])
    {{ Form::close() }}
@endsection