@extends('layouts.app')

@section('title', trans('feed.index.title'))

@section('content')
    <h1>
        {{ trans('feed.index.title') }}
        <small class="text-muted">{{ $totalCountUnreadFeedItems }}</small>
    </h1>

    <p>
        @if ($unreadFeedItems->count() > 0)
            {{ Form::open(['route' => ['feed.mark_all_as_read', $currentCategoryId], 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
                {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> ' . trans('feed.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-outline-dark', 'data-confirm' => true]) }}
            {{ Form::close() }}
        @endif
    </p>

    <ul class="nav nav-pills mt-5 mb-3">
        <li class="nav-item">
            {!! Html::decode(Html::linkRoute('feed.index', trans('feed.index.all_categories') . ' <span class="badge badge-secondary">' . $totalCountUnreadFeedItems . '</span>', [], ['class' => 'nav-link'. ($currentCategoryId == null ? ' active' : '')])) !!}
        </li>

        @foreach ($categories->get() as $category)
            @if (getUnreadFeedItemCountForCategory($category) > 0)
                <li class="nav-item">
                    {!! Html::decode(Html::linkRoute('feed.category', $category->title . ' <span class="badge badge-secondary">' . getUnreadFeedItemCountForCategory($category) . '</span>', [$category->id], ['class' => 'nav-link' . ($currentCategoryId == $category->id ? ' active' : '')])) !!}
                </li>
            @endif
        @endforeach
    </ul>

    @if ($unreadFeedItems->count() == 0)
        <p class="lead font-italic mt-3"><i>{{ trans('feed.index.no_unread_items') }}</i></p>
    @else
        <div>
            @include('shared._pagination', ['items' => $unreadFeedItems])
        </div>

        @include('feed._list', ['feedItems' => $unreadFeedItems, 'showActions' => true, 'categoryId' => $currentCategoryId])

        <div class="mt-4">
            @include('shared._pagination', ['items' => $unreadFeedItems])
        </div>
    @endif
@endsection