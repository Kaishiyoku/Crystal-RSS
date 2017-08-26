<div class="row justify-content-md-center">
    <div class="col col-lg-8">
        <div class="card border-primary">
            <h4 class="card-header text-white bg-primary">
                {{ trans('login.title') }}
            </h4>
            <div class="card-body">
                {{ Form::open(['route' => 'login', 'method' => 'post', 'role' => 'form']) }}
                <div class="form-group row">
                    {{ Form::label('email', trans('login.email'), ['class' => 'col-lg-4 col-form-label']) }}

                    <div class="col-lg-6">
                        {{ Form::email('email', old('email'), ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'required' => true, 'autofocus' => 'true']) }}

                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    {{ Form::label('password', trans('login.password'), ['class' => 'col-lg-4 col-form-label']) }}

                    <div class="col-lg-6">
                        {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invald' : ''), 'required' => true]) }}

                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-8 ml-md-auto">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{ trans('login.remember_me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-8 ml-md-auto">
                        {{ Form::button(trans('login.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}

                        {{ Html::link('/password/reset', trans('login.forgot_password'), ['class' => 'btn btn-link']) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>