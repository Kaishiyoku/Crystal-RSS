@extends('layouts.app')

@section('title', __('feed.index.title'))

@section('content')
    <h1>
        @lang('feed.index.title')
        <small class="text-muted">{{ $totalCountUnreadFeedItems }}</small>
    </h1>

    <p class="text-muted">
        @if ($latestUpdateLog)
            @lang('feed.index.last_update_at', ['date' => $latestUpdateLog->created_at->format(l(DATETIME))])
        @else
            @lang('feed.index.last_update_at_never')
        @endif
    </p>

    <p>
        @if ($unreadFeedItems->count() > 0)
            {{ Form::open(['route' => ['feed.mark_all_as_read', $currentCategoryId], 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
                {{ Form::button('<i class="fas fa-eye"></i> ' . __('feed.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-outline-secondary', 'data-confirm' => true]) }}
            {{ Form::close() }}
        @endif
    </p>

    @if ($totalCountUnreadFeedItems > 0)
        <ul class="nav nav-pills mt-5 mb-3">
            <li class="nav-item">
                {!! Html::decode(Html::linkRoute('feed.index', __('feed.index.all_categories') . ' <span class="badge badge-dark">' . $totalCountUnreadFeedItems . '</span>', [], ['class' => 'nav-link'. ($currentCategoryId == null ? ' active' : '')])) !!}
            </li>

            @foreach ($categories->get() as $category)
                @if (getUnreadFeedItemCountForCategory($category) > 0)
                    <li class="nav-item">
                        {!! Html::decode(Html::linkRoute('feed.category', $category->title . ' <span class="badge badge-dark">' . getUnreadFeedItemCountForCategory($category) . '</span>', [$category->id], ['class' => 'nav-link' . ($currentCategoryId == $category->id ? ' active' : '')])) !!}
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @if ($unreadFeedItems->count() == 0)
        <div class="row pt-3">
            <div class="col-md-4 offset-md-4">
                {{ Html::image('img/no_unread_items.svg', __('feed.index.no_unread_items'), ['class' => 'img-fluid']) }}

                <p class="lead font-italic mt-3 text-center"><i>@lang('feed.index.no_unread_items')</i></p>
            </div>
        </div>
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