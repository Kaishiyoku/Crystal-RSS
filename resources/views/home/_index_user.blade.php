<h1>{{ trans('home.index.feed.title') }}</h1>

<p>
    {{ Form::open(['route' => 'home.update_feeds', 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
        {{ Form::button('<i class="fa fa-refresh" aria-hidden="true"></i> ' . trans('home.index.update_feeds'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}

    @if ($unreadFeedItems->count() > 0)
        {{ Form::open(['route' => 'home.mark_all_as_read', 'method' => 'put', 'role' => 'form', 'class' => 'd-inline']) }}
            {{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i> ' . trans('home.index.mark_all_as_read'), ['type' => 'submit', 'class' => 'btn btn-secondary', 'data-confirm' => true]) }}
        {{ Form::close() }}
    @endif
</p>

@if ($unreadFeedItems->count() == 0)
    <p class="lead"><i>{{ trans('home.index.feed.no_unread_items') }}</i></p>
@else
    @include('shared._feed_item_list', ['feedItems' => $unreadFeedItems->get(), 'showActions' => true])
@endif