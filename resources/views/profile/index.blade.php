@extends('layouts.app')

@section('title', __('profile.index.title'))

@section('content')
    <h1>@lang('profile.index.title')</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>@lang('common.general')</h2>

            <div class="flex">
                <div class="mr-5">
                    @lang('profile.index.registered_at'):
                </div>

                <div>
                    {{ $user->created_at->format(l(DATETIME)) }}
                </div>
            </div>

            <h2>@lang('profile.index.options')</h2>

            <p class="pb-2">
                {!! Html::decode(Html::linkRoute('profile.edit_email', '<i class="fas fa-envelope"></i> ' . __('profile.edit_email.title'), null, ['class' => 'link text-xl'])) !!}
            </p>

            <p class="pb-2">
                {!! Html::decode(Html::linkRoute('profile.edit_password', '<i class="fas fa-key"></i> ' . __('profile.edit_password.title'), null, ['class' => 'link text-xl'])) !!}
            </p>

            <p>
                {!! Html::decode(Html::linkRoute('profile.edit_settings', '<i class="fas fa-sliders-h"></i> ' . __('profile.edit_settings.title'), null, ['class' => 'link text-xl'])) !!}
            </p>
        </div>
    </div>
@endsection
