<div class="card">
    @foreach ($feedItems as $feedItem)
        <a href="{{ route('feed.details', $feedItem) }}" class="flex p-2 hover:bg-gray-200 transition-all duration-200">
            <div class="flex-grow">
                <span class="font-bold">#{{ $feedItem->id }}</span>
                {{ $feedItem->title }}
            </div>

            <div>
                <small>{{ $feedItem->posted_at->format(l(DATETIME)) }}</small>
            </div>
        </a>
    @endforeach
</div>
