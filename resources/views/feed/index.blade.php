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
                {{ Form::button('<i class="fas fa-eye"></i> ' . __('feed.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-outline-dark', 'data-confirm' => true]) }}
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

    <button type="button" class="btn btn-primary">Primary</button>
    <button type="button" class="btn btn-secondary">Secondary</button>
    <button type="button" class="btn btn-success">Success</button>
    <button type="button" class="btn btn-danger">Danger</button>
    <button type="button" class="btn btn-warning">Warning</button>
    <button type="button" class="btn btn-info">Info</button>
    <button type="button" class="btn btn-light">Light</button>
    <button type="button" class="btn btn-dark">Dark</button>

    <button type="button" class="btn btn-link">Link</button>


    <button type="button" class="btn btn-outline-primary">Primary</button>
    <button type="button" class="btn btn-outline-secondary">Secondary</button>
    <button type="button" class="btn btn-outline-success">Success</button>
    <button type="button" class="btn btn-outline-danger">Danger</button>
    <button type="button" class="btn btn-outline-warning">Warning</button>
    <button type="button" class="btn btn-outline-info">Info</button>
    <button type="button" class="btn btn-outline-light">Light</button>
    <button type="button" class="btn btn-outline-dark">Dark</button>

    <div class="alert alert-primary" role="alert">
        A simple primary alert—check it out!
    </div>
    <div class="alert alert-secondary" role="alert">
        A simple secondary alert—check it out!
    </div>
    <div class="alert alert-success" role="alert">
        A simple success alert—check it out!
    </div>
    <div class="alert alert-danger" role="alert">
        A simple danger alert—check it out!
    </div>
    <div class="alert alert-warning" role="alert">
        A simple warning alert—check it out!
    </div>
    <div class="alert alert-info" role="alert">
        A simple info alert—check it out!
    </div>
    <div class="alert alert-light" role="alert">
        A simple light alert—check it out!
    </div>
    <div class="alert alert-dark" role="alert">
        A simple dark alert—check it out!
    </div>
@endsection