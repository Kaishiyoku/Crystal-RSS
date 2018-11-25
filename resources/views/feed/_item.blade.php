<li class="list-group-item font-weight-bold hoverable" id="feed-item-{{ $feedItem->id }}">
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
                    {{ $feedItem->feed->title }}

                    @if (auth()->user()->is_administrator)
                        {{ Html::linkRoute('feed.details', __('feed.index.details'), $feedItem) }}
                    @endif
                </div>
                <div class="col-6 d-none-md d-lg-none d-xl-none text-right small font-weight-bold">
                    {{ $feedItem->date->format(l(DATETIME)) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 text-right d-none d-lg-block d-xl-block">
            {{ $feedItem->date->format(l(DATETIME)) }}
        </div>
    </div>
</li>