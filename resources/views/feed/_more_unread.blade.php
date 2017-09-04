@foreach ($unreadFeedItems->get() as $feedItem)
    @include('feed._item', ['feedItem' => $feedItem, 'showActions' => true])
@endforeach
