<div class="container">
    <div class="row">
        <div class="offset-md-2 col-md-2"></div>

        <div class="col-md-6">
            <h1>@lang('login.title')</h1>
        </div>
    </div>

    {{ Form::open(['route' => 'login', 'method' => 'post', 'role' => 'form']) }}
        <div class="form-group row">
            {{ Form::label('email', __('login.email'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

            <div class="col-md-6">
                {{ Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true, 'autofocus' => 'true']) }}

                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('password', __('login.password'), ['class' => 'offset-md-2 col-md-2 col-form-label text-md-right']) }}

            <div class="col-md-6">
                {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invald' : ''), 'required' => true]) }}

                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-2"></div>

            <div class="col-md-5">
                <div class="custom-control custom-checkbox">
                    {{ Form::checkbox('remember', 1, false, ['class' => 'custom-control-input', 'id' => 'remember']) }}
                    {{ Form::label('remember', __('login.remember_me'), ['class' => 'custom-control-label']) }}
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-2"></div>

            <div class="col-md-5">
                {{ Form::button(__('login.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}

                {{ Html::link('/password/reset', __('login.forgot_password'), ['class' => 'btn btn-link']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
