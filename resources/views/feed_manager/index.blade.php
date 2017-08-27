@extends('layouts.app')

@section('title', trans('feed_manager.index.title'))

@section('content')
    <h1>{{ trans('feed_manager.index.title') }}</h1>

    <p>
        {{ Html::linkRoute('manage_feeds.create', trans('feed_manager.create.title'), [], ['class' => 'btn btn-primary']) }}
    </p>

    @if ($feeds->count() == 0)
        <p class="lead">
            <i>{{ trans('feed_manager.index.no_feeds_yet') }}</i>
        </p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ trans('validation.attributes.title') }}</th>
                <th>{{ trans('validation.attributes.last_checked_at') }}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($feeds->get() as $feed)
                <tr>
                    <td>{{ $feed->title }}</td>
                    <td>{{ $feed->last_checked_at->format(DATETIME) }}</td>
                    <td>
                        @include('shared._delete_link', ['route' => ['manage_feeds.destroy', $feed->id]])
                    </td>
                    <td>{{ Html::linkRoute('manage_feeds.edit', trans('common.edit'), [$feed->id]) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection