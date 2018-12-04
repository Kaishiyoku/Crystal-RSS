@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <div>
        {!! $dailyArticlesChart->container() !!}
        {!! $dailyArticlesChart->script() !!}
    </div>
@endsection