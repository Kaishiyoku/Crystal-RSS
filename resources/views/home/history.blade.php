@extends('layouts.app')

@section('title', trans('home.history.title'))

@section('content')
    <h1>{{ trans('home.history.title') }}</h1>

    @if ($unreadFeedItems->count() > 0)
        <h2>{{ trans('home.history.unread') }}</h2>

        <table class="table table-striped table-hover">
            <tbody>
            @foreach ($unreadFeedItems->get() as $feedItem)
                <tr class="{{ !$feedItem->is_read ? 'font-weight-bold' : '' }}" id="feed-item-{{ $feedItem->id }}">
                    <td>
                        @if (!$feedItem->is_read)
                            {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i>', [
                                'class' => 'btn btn-outline-primary btn-sm',
                                'data-mark-as-read' => URL::route('home.mark_feed_item_as_read', [$feedItem->id]), 'data-target' => '#feed-item-' . $feedItem->id]) }}
                        @endif
                    </td>
                    <td>{{ Html::link($feedItem->url, $feedItem->title) }}</td>
                    <td class="text-right">{{ $feedItem->date->format(DATETIME) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <h2>{{ trans('home.history.read') }}</h2>

    @if ($readFeedItems->count() == 0)
        <p class="lead"><i>{{ trans('home.history.no_items') }}</i></p>
    @else
        <table class="table table-striped table-hover">
            <tbody>
            @foreach ($readFeedItems->get() as $feedItem)
                <tr class="{{ !$feedItem->is_read ? 'font-weight-bold' : '' }}" id="feed-item-{{ $feedItem->id }}">
                    <td></td>
                    <td>{{ Html::link($feedItem->url, $feedItem->title) }}</td>
                    <td class="text-right">{{ $feedItem->date->format(DATETIME) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection