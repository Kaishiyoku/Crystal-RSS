<div class="list-item {{ $feedItem->isDuplicate() > 0 ? 'list-item-duplicate' : '' }}" id="feed-item-{{ $feedItem->id }}" {!! $feedItem->feed->getStyle(\App\Enums\StyleType::BORDER()) !!}>
    <div class="flex items-start py-3 pr-3">
        @if ($showActions)
            <label for="feedIds-{{ $feedItem->id }}" class="label-checkbox pl-5">
                {{ Form::checkbox('feedIds[]', $feedItem->id, false, ['class' => 'checkbox', 'id' => 'feedIds-' . $feedItem->id]) }}
            </label>
        @endif

        <div class="flex-grow pl-5">
            <div>
                {{ Html::link($feedItem->url, $feedItem->title, ['class' => 'link']) }}

                @if ($feedItem->isDuplicate())
                    <span class="text-muted text-xs">[{{ __('feed.duplicate') }}]</span>
                @endif
            </div>

            <div class="text-sm">
                <i class="fas fa-rss"></i>
                <span class="pr-2" {!! $feedItem->feed->getStyle() !!}>
                    {{ $feedItem->feed->title }}
                </span>

                <i class="fas fa-tags"></i>
                @include('feed._categories', ['categories' => $feedItem->categories])
            </div>
        </div>

        <div class="col-lg-3 text-right d-none d-lg-block d-xl-block">
            <div>{{ $feedItem->posted_at->format(l(DATETIME)) }}</div>

            <div>
                @if (auth()->user()->is_administrator)
                    {{ Html::linkRoute('feed.details', __('feed.index.details'), $feedItem, ['class' => 'btn btn-sm btn-outline-primary-dark']) }}
                @endif

                @include('feed._additional_item_actions')
            </div>
        </div>
    </div>
</div>
