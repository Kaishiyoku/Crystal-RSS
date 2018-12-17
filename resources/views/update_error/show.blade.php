@extends('layouts.app')

@section('title', __('update_error.show.title', ['id' => $updateError->id]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('update_errors.show') !!}
@endsection

@section('content')
    <h1>@lang('update_error.show.title', ['id' => $updateError->id])</h1>

    <div>
        {{ $updateError->content }}
    </div>
@endsection