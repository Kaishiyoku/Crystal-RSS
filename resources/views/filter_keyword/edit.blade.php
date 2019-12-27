@extends('layouts.app')

@section('title', __('filter_keyword.edit.title'))

@section('breadcrumbs')
    {!! Breadcrumbs::render('filter_keywords.edit', $filterKeyword) !!}
@endsection

@section('content')
    <h1>@lang('filter_keyword.edit.title', ['value' => $filterKeyword->value])</h1>

    {{ Form::open(['route' => ['filter_keywords.update', $filterKeyword], 'method' => 'put', 'role' => 'form']) }}
        @include('filter_keyword._form', ['submitTitle' => __('common.update')])
    {{ Form::close() }}
@endsection
