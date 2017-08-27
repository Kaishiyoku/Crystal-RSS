<h1>{{ trans('home.index.feed.title') }}</h1>

<p>
    {{ Form::open(['route' => 'home.update_feeds', 'method' => 'put', 'role' => 'form']) }}
        {{ Form::button(trans('home.index.update_feeds'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}
</p>

@if ($unreadFeedItems->count() == 0)
    <p class="lead"><i>{{ trans('home.index.feed.no_unread_items') }}</i></p>
@else
    @foreach ($unreadFeedItems->get() as $unreadFeedItem)
        <p>
            {{ $unreadFeedItem->title }}
        </p>
    @endforeach
@endif