<h1>{{ trans('home.index.feed.title') }}</h1>

<p>
    {{ Form::open(['route' => 'home.update_feeds', 'method' => 'put', 'role' => 'form']) }}
        {{ Form::button(trans('home.index.update_feeds'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    {{ Form::close() }}
</p>

@if ($unreadFeedItems->count() == 0)
    <p class="lead"><i>{{ trans('home.index.feed.no_unread_items') }}</i></p>
@else
    <table class="table table-striped table-hover">
        <tbody>
        @foreach ($unreadFeedItems->get() as $unreadFeedItem)
            <tr class="font-weight-bold" id="feed-item-{{ $unreadFeedItem->id }}">
                <td>{{ Form::button('<i class="fa fa-eye" aria-hidden="true"></i>', [
                        'class' => 'btn btn-outline-primary btn-sm',
                        'data-mark-as-read' => URL::route('home.mark_feed_item_as_read', [$unreadFeedItem->id]), 'data-target' => '#feed-item-' . $unreadFeedItem->id]) }}</td>
                <td>{{ Html::link($unreadFeedItem->url, $unreadFeedItem->title) }}</td>
                <td class="text-right">{{ $unreadFeedItem->date->format(DATETIME) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif