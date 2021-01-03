<div class="list-item {{ $feedItem->isDuplicate() > 0 ? 'list-item-duplicate' : '' }}" id="feed-item-{{ $feedItem->id }}" {!! $feedItem->feed->getStyle(\App\Enums\StyleType::BORDER()) !!}>
    <div class="{{ classNames('md:flex md:items-start py-3 pr-3', ['pl-3' => !$showActions]) }}">
        <div class="flex flex-grow">
            @if ($showActions)
                <label for="feedIds-{{ $feedItem->id }}" class="label-checkbox pl-5">
                    {{ Form::checkbox('feedIds[]', $feedItem->id, false, ['class' => 'checkbox', 'id' => 'feedIds-' . $feedItem->id]) }}
                </label>
            @endif

            <div class="flex-growpl-5">
                <div>
                    {{ Html::link($feedItem->url, $feedItem->title, ['class' => 'link']) }}

                    @if ($feedItem->isDuplicate())
                        <span class="text-muted text-xs">[{{ __('feed.duplicate') }}]</span>
                    @endif
                </div>

                <div class="flex md:block justify-between text-xs md:text-sm">
                    <span>
                        <i class="fas fa-rss"></i>
                        <span class="pr-2" {!! $feedItem->feed->getStyle() !!}>
                            {{ $feedItem->feed->title }}
                        </span>
                    </span>

                    <span class="md:hidden text-right">
                        {{ $feedItem->posted_at->format(l(DATETIME)) }}
                    </span>

                    <span class="hidden md:inline-block">
                        <i class="fas fa-tags"></i>
                        @include('feed._categories', ['categories' => $feedItem->categories])
                    </span>
                </div>
            </div>
        </div>

        <div class="text-right md:w-48 pt-1 md:pt-0">
            <div class="hidden md:block">{{ $feedItem->posted_at->format(l(DATETIME)) }}</div>

            <div>
                @if (auth()->user()->is_administrator)
                    {{ Html::linkRoute('feed.details', __('feed.index.details'), $feedItem, ['class' => 'btn btn-sm btn-primary-dark']) }}
                @endif

                @include('feed._additional_item_actions')
            </div>
        </div>
    </div>
</div>
