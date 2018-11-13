@extends('layouts.app')

@section('title', __('profile.index.title'))

@section('content')
    <h1>@lang('profile.index.title')</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>@lang('common.general')</h2>

            <div class="row">
                <div class="col-md-6">
                    @lang('profile.index.registered_at'):
                </div>

                <div class="col-md-6">
                    {{ $user->created_at->format(DATETIME) }}
                </div>
            </div>

            <h2>@lang('profile.index.options')</h2>

            <p class="lead p-t-10">
                {!! Html::decode(Html::linkRoute('profile.edit_email', '<i class="fa fa-envelope" aria-hidden="true"></i> ' . __('profile.edit_email.title'))) !!}
            </p>

            <p class="lead">
                {!! Html::decode(Html::linkRoute('profile.edit_password', '<i class="fa fa-key" aria-hidden="true"></i> ' . __('profile.edit_password.title'))) !!}
            </p>
        </div>
    </div>
@endsection