@extends('emails.layouts.app')

@section('title', trans('auth.emails.deactivation.title'))

@section('content')
    <p>
        {{ trans('auth.emails.deactivation.your_account_has_been_deactivated', ['name' => $user->name]) }}
    </p>
@endsection