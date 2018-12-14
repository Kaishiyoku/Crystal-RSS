{{ Form::open(['route' => 'feed.search_result', 'method' => 'get', 'role' => 'form']) }}
    <div class="form-group row">
        {{ Form::label('term', __('validation.attributes.term'), ['class' => 'col-lg-2 col-form-label']) }}

        <div class="col-lg-5">
            {{ Form::text('query', request()->query('query'), ['class' => 'form-control' . ($errors->has('query') ? ' is-invalid' : ''), 'required' => true]) }}

            @if ($errors->has('query'))
                <div class="invalid-feedback">
                    {{ $errors->first('query') }}
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