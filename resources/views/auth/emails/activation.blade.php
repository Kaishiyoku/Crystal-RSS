@extends('emails.layouts.app')

@section('title', __('auth.emails.activation.title'))

@section('content')
    <p>
        @lang('auth.emails.activation.your_account_has_been_activated', ['name' => $user->name])
    </p>

    <p>
        @lang('auth.emails.activation.you_may_login_now'): {{ Html::linkRoute('login') }}
    </p>
@endsection