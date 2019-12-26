<div class="list-group">
    @foreach ($feedItems as $feedItem)
        <a href="{{ route('feed.details', $feedItem) }}" class="list-group-item list-group-item-action">
            <div class="row">
                <div class="col-lg-9 col-8">
                    #{{ $feedItem->id }} {{ $feedItem->title }}
                </div>

                <div class="col-lg-3 col-4 text-right">
                    <small>{{ $feedItem->posted_at->format(l(DATETIME)) }}</small>
                </div>
            </div>
        </a>
    @endforeach
</div>
