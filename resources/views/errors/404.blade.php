@extends('errors.layouts.app')

@section('content')
    <h1>{{ trans('common.errors.404.title') }}</h1>

    <h2>{{ trans('common.errors.404.content') }}</h2>

    <p class="pt-5">
        {{ Html::link('/', trans('common.back_to_landing_page'), ['class' => 'btn btn-primary btn-lg']) }}
    </p>
@endsection