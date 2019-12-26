<li class="list-group-item border-0 hoverable {{ $feedItem->isDuplicate() > 0 ? 'list-group-item-warning' : '' }}" id="feed-item-{{ $feedItem->id }}">
    <div class="row">
        @if ($showActions)
            <div class="col-lg-1 col-2">
                <div class="custom-control custom-checkbox">
                    {{ Form::checkbox('feedIds[]', $feedItem->id, false, ['class' => 'custom-control-input', 'id' => 'feedIds-' . $feedItem->id]) }}
                    <label class="custom-control-label custom-control-label-lg d-inline" for="feedIds-{{ $feedItem->id }}"></label>
                </div>
            </div>
        @endif
        <div class="col-lg-{{ $showActions ? '8' : '9' }} col-{{ $showActions ? '10' : '12' }}">
            <div>
                {{ Html::link($feedItem->url, $feedItem->title) }}

                @if ($feedItem->isDuplicate())
                    <small class="text-muted">[{{ __('feed.duplicate') }}]</small>
                @endif
            </div>

            <div class="row">
                <div class="col-6 col-lg-12 small">
                    <i class="fas fa-rss"></i>
                    <span class="pr-2" {!! $feedItem->feed->getStyle() !!}>
                        {{ $feedItem->feed->title }}
                    </span>

                    <i class="fas fa-tags"></i>
                    @include('feed._categories', ['categories' => $feedItem->categories])

                    <span class="d-lg-none d-xl-none">
                        @include('feed._additional_item_actions')
                    </span>
                </div>
                <div class="col-6 d-none-md d-lg-none d-xl-none text-right small">
                    {{ $feedItem->posted_at->format(l(DATETIME)) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right d-none d-lg-block d-xl-block">
            {{ $feedItem->posted_at->format(l(DATETIME)) }}

            <br/>

            @if (auth()->user()->is_administrator)
                {{ Html::linkRoute('feed.details', __('feed.index.details'), $feedItem, ['class' => 'btn btn-xs btn-outline-dark']) }}
            @endif

            @include('feed._additional_item_actions')
        </div>
    </div>
</li>
