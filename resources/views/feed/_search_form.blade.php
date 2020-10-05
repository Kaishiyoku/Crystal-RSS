{{ Form::open(['route' => 'feed.search_result', 'method' => 'get', 'role' => 'form']) }}
    <div class="mb-4">
        {{ Form::label('term', __('validation.attributes.term'), ['class' => 'label']) }}

        {{ Form::text('term', request()->query('term'), ['class' => 'input' . ($errors->has('term') ? ' has-error' : ''), 'required' => true]) }}

        @if ($errors->has('term'))
            <div class="invalid-feedback">
                {{ $errors->first('term') }}
            </div>
        @endif
    </div>

    <div class="mb-4">
        <div class="md:flex md:justify-between">
            <div class="md:mr-5 mb-4 md:mb-0">
                {{ Form::label('feed_ids', __('feed.search.feed_ids'), ['class' => 'label']) }}

                <div
                    data-provide="multiselect"
                    data-name="feed_ids"
                    data-button-title="{{ __('feed.search.feed_ids') }}"
                    data-entries="{{ json_encode($feeds) }}"
                >
                </div>
            </div>

            <div class="md:flex">
                <div class="mb-4 md:mr-5">
                    {{ Form::label('date_from', __('feed.date_from'), ['class' => 'label']) }}

                    {{ Form::date('date_from', request()->query('date_from'), ['class' => 'input' . ($errors->has('date_from') ? ' has-error' : '')]) }}

                    @if ($errors->has('date_from'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_from') }}
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    {{ Form::label('date_till', __('feed.date_till'), ['class' => 'label']) }}

                    {{ Form::date('date_till', request()->query('date_till'), ['class' => 'input' . ($errors->has('date_till') ? ' has-error' : '')]) }}

                    @if ($errors->has('date_till'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_till') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{ Form::button(__('feed.search_show.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}
