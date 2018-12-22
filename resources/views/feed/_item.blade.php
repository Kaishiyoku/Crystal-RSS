<li class="list-group-item border-0 hoverable" id="feed-item-{{ $feedItem->id }}">
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
            <div>{{ Html::link($feedItem->url, $feedItem->title) }}</div>

            <div class="row">
                <div class="col-6 col-lg-12 small">
                    <i class="fas fa-rss"></i>
                    <span class="pr-2" {!! $feedItem->feed->getStyle() !!}>
                        {{ $feedItem->feed->title }}
                    </span>

                    <i class="fas fa-tags"></i>
                    @include('feed._categories', ['categories' => $feedItem->categories])
                </div>
                <div class="col-6 d-none-md d-lg-none d-xl-none text-right small">
                    {{ $feedItem->date->format(l(DATETIME)) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right d-none d-lg-block d-xl-block">
            {{ $feedItem->date->format(l(DATETIME)) }}

            <br/>

            @if (auth()->user()->is_administrator)
                <span class="small">
                    {{ Html::linkRoute('feed.details', __('feed.index.details'), $feedItem) }}
                </span>
            @endif
        </div>
    </div>
</li>