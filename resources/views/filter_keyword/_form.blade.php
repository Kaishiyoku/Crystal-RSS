{{ Form::label('value', __('validation.attributes.value'), ['class' => 'label']) }}

<div class="mb-4">
    {{ Form::text('value', old('value', $filterKeyword->value), ['class' => 'input' . ($errors->has('value') ? ' has-error' : ''), 'required' => true]) }}

    @if ($errors->has('value'))
        <div class="invalid-feedback">
            {{ $errors->first('value') }}
        </div>
    @endif
</div>

{{ Form::button($submitTitle, ['type' => 'submit', 'class' => 'btn btn-primary']) }}
