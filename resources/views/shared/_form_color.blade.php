<div class="mb-4">
    {{ Form::label('color', __('validation.attributes.color'), ['class' => 'label']) }}

    <div class="col-lg-5">
        {{ Form::text('color', old('color', $item->color), ['class' => 'input' . ($errors->has('color') ? ' has-error' : ''), 'autocomplete' => 'off', 'aria-describedby' => 'color_addon', 'data-provide' => 'minicolors']) }}

        @if ($errors->has('color'))
            <div class="invalid-feedback">
                {{ $errors->first('color') }}
            </div>
        @endif
    </div>
</div>
