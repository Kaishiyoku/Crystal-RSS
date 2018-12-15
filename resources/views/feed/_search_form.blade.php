{{ Form::open(['route' => 'feed.search_result', 'method' => 'get', 'role' => 'form']) }}
    <div class="form-group row">
        {{ Form::label('term', __('validation.attributes.term'), ['class' => 'col-lg-2 col-form-label']) }}

        <div class="col-lg-5">
            {{ Form::text('term', request()->query('term'), ['class' => 'form-control' . ($errors->has('term') ? ' is-invalid' : ''), 'required' => true]) }}

            @if ($errors->has('term'))
                <div class="invalid-feedback">
                    {{ $errors->first('term') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('feed_ids', __('feed.search.feed_ids'), ['class' => 'col-lg-2 col-form-label']) }}

        <div class="col-lg-5">
            {{ Form::select('feed_ids[]', $feeds, request()->query('feed_ids') ?? $feedIds, ['multiple' => true, 'size' => 15, 'data-provide' => 'multiselect', 'class' => 'd-none']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('date_from', __('feed.date_from'), ['class' => 'col-lg-2 col-form-label']) }}

        <div class="col-lg-2">
            <div class="input-group date" id="date_from_picker" data-target-input="nearest" data-provide="datepicker">
                {{ Form::text('date_from', request()->query('date_from'), ['class' => 'form-control datetimepicker-input' . ($errors->has('date_from') ? ' is-invalid' : ''), 'data-target' => '#date_from_picker']) }}

                <div class="input-group-append" data-target="#date_from_picker" data-toggle="datetimepicker">
                    <button type="button" class="btn btn-outline-dark"><i class="fas fa-calendar"></i></button>
                </div>
            </div>

            @if ($errors->has('date_from'))
                <div class="invalid">
                    {{ $errors->first('date_from') }}
                </div>
            @endif
        </div>

        {{ Form::label('date_till', __('feed.date_till'), ['class' => 'col-lg-1 col-form-label']) }}

        <div class="col-lg-2">
            <div class="input-group date" id="date_till_picker" data-target-input="nearest" data-provide="datepicker">
                {{ Form::text('date_till', request()->query('date_till'), ['class' => 'form-control datetimepicker-input' . ($errors->has('date_till') ? ' is-invalid' : ''), 'data-target' => '#date_till_picker']) }}

                <div class="input-group-append" data-target="#date_till_picker" data-toggle="datetimepicker">
                    <button type="button" class="btn btn-outline-dark"><i class="fas fa-calendar"></i></button>
                </div>
            </div>

            @if ($errors->has('date_till'))
                <div class="invalid">
                    {{ $errors->first('date_till') }}
                </div>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <div class="col-lg-10 ml-md-auto">
            {{ Form::button(__('feed.search_show.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        </div>
    </div>
{{ Form::close() }}