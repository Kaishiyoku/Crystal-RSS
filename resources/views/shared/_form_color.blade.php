<div class="form-group row">
    {{ Form::label('color', __('validation.attributes.color'), ['class' => 'col-lg-2 col-form-label']) }}

    <div class="col-lg-2">
        {{ Form::text('color', old('color', $item->color), ['class' => 'form-control' . ($errors->has('color') ? ' is-invalid' : ''), 'autocomplete' => 'off', 'aria-describedby' => 'color_addon', 'data-provide' => 'minicolors']) }}

        @if ($errors->has('color'))
            <div class="invalid-feedback">
                {{ $errors->first('color') }}
            </div>
        @endif
    </div>
</div>