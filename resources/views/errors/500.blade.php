@extends('errors::illustrated-layout')

@section('code', '500')
@section('title', __('errors.500.title'))

@section('image')
<div style="background-image: url('/svg/500.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('errors.500.message'))
