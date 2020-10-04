<div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
    <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('login.title')</div>

    {{ Form::open(['route' => 'login', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
        {{ Form::label('email', __('login.email'), ['class' => 'label']) }}

        <div class="mb-4">
            {{ Form::email('email', old('email'), ['class' => 'input' . ($errors->has('email') ? ' has-error' : ''), 'required' => true, 'autofocus' => 'true', 'placeholder' => __('login.email')]) }}

            @if ($errors->has('email'))
                <p class="invalid-feedback">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('password', __('login.password'), ['class' => 'label']) }}

            {{ Form::password('password', ['class' => 'input' . ($errors->has('password') ? ' has-error' : ''), 'required' => true, 'placeholder' => __('login.password')]) }}

            @if ($errors->has('password'))
                <p class="invalid-feedback">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <label for="remember" class="label-checkbox">
            {{ Form::checkbox('remember', 1, false, ['class' => 'checkbox', 'id' => 'remember']) }}
            <span>{{ __('login.remember_me') }}</span>
        </label>

        <div class="flex items-center justify-between pt-4">
            {{ Form::button(__('login.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}

            {{ Html::link('/password/reset', __('login.forgot_password'), ['class' => 'inline-block align-baseline font-bold text-primary hover:text-black transition-all duration-200']) }}
        </div>
    {{ Form::close() }}
</div>
