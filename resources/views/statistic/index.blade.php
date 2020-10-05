@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <h1>
        @lang('statistic.index.title')

        <span class="headline-info">@lang('statistic.index.last_month')</span>
    </h1>

    <div class="card">
        {!! $dailyArticlesChart->assets() !!}
        {!! $dailyArticlesChart->render() !!}
    </div>

    <div class="card my-5 px-2 py-3">
        <p class="mb-5">
            @lang('statistic.index.average_time_between_retrieval_and_read'): {{ $averageDurationBetweenRetrievalAndRead->humanize() }}
        </p>

        <p>
            @lang('statistic.index.total_number_of_feed_items'): {{ auth()->user()->feedItems()->count() }}
        </p>
    </div>

    <div class="card text-sm md:text-base">
        @foreach ($categories as $category)
            <div class="mb-5">
                <div class="flex font-bold p-2 hover:bg-gray-200 transition-all duration-200">
                    <div class="w-full text-lg" {!! $category->getStyle() !!}>{{ $category->title }}</div>
                    <div class="w-24 text-right">
                        <span class="text-success-900">
                            <i class="fas fa-chevron-up"></i>
                            {{ $category->getTotalUpVoteCount() }}
                        </span>

                        <span class="text-danger-900">
                            <i class="fas fa-chevron-down"></i>
                            {{ $category->getTotalDownVoteCount() }}
                        </span>
                    </div>
                    <div class="w-32 text-lg text-right">{{ $category->getTotalFeedCount() }}</div>
                </div>

                @foreach ($category->feeds as $feed)
                    <div class="flex px-2 pb-1 hover:bg-gray-200 transition-all duration-200">
                        <div class="w-full" {!! $feed->getStyle() !!}>{{ $feed->title }}</div>
                        <div class="w-24 text-right">
                            <span class="text-success-900">
                                <i class="fas fa-chevron-up"></i>
                                {{ $feed->getTotalUpVoteCount() }}
                            </span>

                            <span class="text-danger-900">
                                <i class="fas fa-chevron-down"></i>
                                {{ $feed->getTotalDownVoteCount() }}
                            </span>
                        </div>
                        <div class="w-32 text-right">{{ $feed->feedItems()->count() }}</div>
                    </div>
                @endforeach
            </div>

            <hr/>
        @endforeach
    </div>
@endsection
