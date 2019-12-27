@extends('layouts.app')

@section('title', __('filter_keyword.create.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('filter_keywords.create') !!}
@endsection

@section('content')
    <h1>@lang('filter_keyword.create.title')</h1>

    {{ Form::open(['route' => 'filter_keywords.store', 'method' => 'post', 'role' => 'form']) }}
        @include('filter_keyword._form', ['submitTitle' => __('common.create')])
    {{ Form::close() }}
@endsection
