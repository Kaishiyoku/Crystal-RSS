<div class="form-group row">
    {{ Form::label('value', __('validation.attributes.value'), ['class' => 'col-lg-2 col-form-label']) }}

    <div class="col-lg-3">
        {{ Form::text('value', old('value', $filterKeyword->value), ['class' => 'form-control' . ($errors->has('value') ? ' is-invalid' : ''), 'required' => true]) }}

        @if ($errors->has('value'))
            <div class="invalid-feedback">
                {{ $errors->first('value') }}
            </div>
        @endif
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-10 ml-md-auto">
        {{ Form::button($submitTitle, ['type' => 'submit', 'class' => 'btn btn-primary']) }}
    </div>
</div>
