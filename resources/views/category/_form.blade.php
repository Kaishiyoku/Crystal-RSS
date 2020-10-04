{{ Form::label('title', __('validation.attributes.title'), ['class' => 'label']) }}

<div class="mb-4">
    {{ Form::text('title', old('title', $category->title), ['class' => 'input' . ($errors->has('title') ? ' has-error' : ''), 'required' => true]) }}

    @if ($errors->has('title'))
        <div class="invalid-feedback">
            {{ $errors->first('title') }}
        </div>
    @endif
</div>

@include('shared._form_color', ['item' => $category])

{{ Form::button($submitTitle, ['type' => 'submit', 'class' => 'btn btn-primary']) }}
