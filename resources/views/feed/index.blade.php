@extends('layouts.app')

@section('title', __('feed.index.title'))

@section('content')
    @if (auth()->user()->feeds()->invalidAndEnabled()->count() > 0)
        @include('shared._alert', ['content' => __('feed.you_have_invalid_feeds'), 'link' => Html::linkRoute('feed.manage.index', __('feed.check_feeds'), null, ['class' => 'btn btn-dark btn-sm']), 'type' => 'danger'])
    @endif

    <h1>
        @lang('feed.index.title')
        <span class="headline-info">{{ $totalCountUnreadFeedItems }}</span>
    </h1>

    <p class="text-muted">
        @if ($latestUpdateLog)
            @lang('feed.index.last_update_at', ['date' => $latestUpdateLog->created_at->format(l(DATETIME))])
        @else
            @lang('feed.index.last_update_at_never')
        @endif
    </p>

    <p class="my-5">
        @if ($unreadFeedItems->count() > 0)
            {{ Form::open(['route' => ['feed.mark_all_as_read', $currentCategoryId], 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
                {{ Form::button('<i class="fas fa-eye"></i> ' . __('feed.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-outline-primary', 'data-confirm' => true]) }}
            {{ Form::close() }}
        @endif
    </p>


    @if ($totalCountUnreadFeedItems > 0)
        <div class="my-5">
            <button class="btn btn-secondary" type="button" data-provide-dropdown="true" data-dropdown-target="#categoryDropdownMenuButton">
                <i class="fas fa-filter"></i>

                {{ $categoryDropdownTranslation }}
                &nbsp;
                <span class="badge badge-dark">{{ $unreadFeedItems->total() }}</span>

                <i class="fas fa-caret-down mt-1"></i>
            </button>

            <div id="categoryDropdownMenuButton" class="dropdown flex flex-col hidden rounded-md shadow-xl">
                {!! Html::decode(Html::linkRoute('feed.index', __('feed.index.all_categories') . ' <span class="badge badge-dark">' . $totalCountUnreadFeedItems . '</span>', [], ['class' => 'dropdown-item'. ($currentCategoryId == null ? ' dropdown-item-active' : '')])) !!}

                @foreach ($categories as $category)
                    @if ($category->total_feed_items_count > 0)
                        {!! Html::decode(Html::linkRoute('feed.category', $category->title . ' <span class="badge badge-dark">' . $category->total_feed_items_count . '</span>', [$category->id], ['class' => 'dropdown-item' . ($currentCategoryId == $category->id ? ' dropdown-item-active' : '')])) !!}
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    @if ($unreadFeedItems->count() === 0)
        {{ Html::image('img/no_unread_items.svg', __('feed.index.no_unread_items'), ['class' => 'h-64 mx-auto']) }}

        <p class="italic mt-3 text-center"><i>@lang('feed.index.no_unread_items')</i></p>
    @else
        <div>
            {{ $unreadFeedItems->links() }}
        </div>

        @include('feed._list', ['feedItems' => $unreadFeedItems, 'showActions' => true, 'categoryId' => $currentCategoryId])

        <div class="mt-4">
            {{ $unreadFeedItems->links() }}
        </div>
    @endif
@endsection
