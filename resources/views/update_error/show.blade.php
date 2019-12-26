@extends('layouts.app')

@section('title', __('update_error.show.title', ['id' => $updateError->id]))

@section('breadcrumbs')
    {!! Breadcrumbs::render('update_errors.show') !!}
@endsection

@section('content')
    <h1>@lang('update_error.show.title', ['id' => $updateError->id])</h1>

    <div class="mb-4">
        <code class="text-dark">
            {{ $updateError->content }}
        </code>
    </div>

    <p>
        {{ Html::linkRoute('update_errors.index', __('common.back')) }}
    </p>
@endsection
