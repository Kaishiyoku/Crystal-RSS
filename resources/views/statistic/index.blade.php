@extends('layouts.app')

@section('title', __('statistic.index.title'))

@section('content')
    <h1>
        @lang('statistic.index.title')

        <span class="headline-info">
            @if ($endingDate->isCurrentMonth())
                @lang('statistic.index.last_month')
            @else
                {{ utf8_encode($endingDate->formatLocalized(__('common.localized_date_formats.month_and_year'))) }}
            @endif
        </span>
    </h1>

    <div class="mb-5 text-right">
        <a href="{{ route('statistics.index', ['startingYear' => $previousDate->year, 'startingMonth' => $previousDate->month]) }}" class="flex btn btn-primary">
            <i class="fas fa-angle-left"></i>
            {{ __('pagination.previous') }}
        </a>

        @if ($nextDate->isBefore(now()))
            <a href="{{ route('statistics.index', ['startingYear' => $nextDate->year, 'startingMonth' => $nextDate->month]) }}" class="btn btn-primary">
                {{ __('pagination.next') }}
                <i class="fas fa-angle-right"></i>
            </a>
        @endif
    </div>

    @if ($feedItemsCount === 0)
        {{ Html::image('img/no_unread_items.svg', __('feed.index.no_unread_items'), ['class' => 'h-64 mx-auto']) }}

        <p class="italic mt-3 text-center">{{ __('statistic.index.no_data_available') }}</p>
    @else
        <div class="card">
            {!! $dailyArticlesChart->assets() !!}
            {!! $dailyArticlesChart->render() !!}
        </div>
    @endif

    <div class="card my-5 px-2 py-3">
        @if ($averageDurationBetweenRetrievalAndRead)
            <p class="mb-5">
                @lang('statistic.index.average_time_between_retrieval_and_read'):
                {{ $averageDurationBetweenRetrievalAndRead->humanize() }}
            </p>
        @endif

        <p>
            @lang('statistic.index.total_number_of_feed_items'): {{ auth()->user()->feedItems()->with('feed')->whereHas('feed')->read()->unhidden()->count() }}
        </p>
    </div>

    @if ($categories->isNotEmpty())
        <div class="card text-sm md:text-base">
            @foreach ($categories as $category)
                @if ($category->feeds->isNotEmpty())
                    <div class="mb-5 border-t border-gray-100">
                        <div class="flex font-bold p-2 hover:bg-gray-50 transition-all duration-200">
                            <div class="w-full text-base md:text-lg" {!! $category->style !!}>{{ $category->title }}</div>
                            <div class="w-40 md:w-48 text-right">
                                <span class="text-success-900 mr-2">
                                    <i class="fas fa-chevron-up"></i>
                                    {{ $category->total_upvote_count }}
                                </span>

                                <span class="text-danger-900">
                                    <i class="fas fa-chevron-down"></i>
                                    {{ $category->total_downvote_count }}
                                </span>
                            </div>
                            <div class="w-32 md:text-lg text-right">{{ $category->total_feed_items_count }}</div>
                        </div>

                        @foreach ($category->feeds as $feed)
                            <div class="flex px-2 pb-1 hover:bg-gray-50 transition-all duration-200">
                                <div class="w-full" {!! $feed->style !!}>{{ $feed->title }}</div>
                                <div class="w-40 md:w-48 text-right">
                                    <span class="text-success-900 mr-2">
                                        <i class="fas fa-chevron-up"></i>
                                        {{ $feed->total_upvote_count }}
                                    </span>

                                    <span class="text-danger-900">
                                        <i class="fas fa-chevron-down"></i>
                                        {{ $feed->total_downvote_count }}
                                    </span>
                                </div>
                                <div class="w-32 text-right">{{ $feed->total_feed_items_count }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    @endif
@endsection
