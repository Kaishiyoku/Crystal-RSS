@extends('layouts.app')

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

            <h2>{{ __('profile.index.options') }}</h2>

            <p class="lead p-t-10">
                {!! Html::decode(Html::linkRoute('profile.edit_password', '<i class="fa fa-key" aria-hidden="true"></i> ' . __('profile.edit_password.title'))) !!}
            </p>
        </div>
    </div>
@endsection