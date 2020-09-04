<div class="mx-auto w-full max-w-sm bg-white shadow-md rounded text-left">
    <div class="text-xl pb-4 text-gray-600 bg-gray-100 pt-4 pl-8">@lang('login.title')</div>

    {{ Form::open(['route' => 'login', 'method' => 'post', 'role' => 'form', 'class' => 'px-8 pt-6 pb-8 mb-4']) }}
        {{ Form::label('email', __('login.email'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

        <div class="mb-4">
            {{ Form::email('email', old('email'), ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('email') ? ' border-red-500' : ''), 'required' => true, 'autofocus' => 'true', 'placeholder' => __('login.email')]) }}

            @if ($errors->has('email'))
                <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="mb-4">
            {{ Form::label('password', __('login.password'), ['class' => 'block text-gray-700 text-sm font-bold mb-2']) }}

            <div class="col-md-6">
                {{ Form::password('password', ['class' => 'shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-all duration-200' . ($errors->has('password') ? ' border-red-500' : ''), 'required' => true, 'placeholder' => __('login.password')]) }}

                @if ($errors->has('password'))
                    <p class="text-red-500 text-xs italic pt-2">{{ $errors->first('password') }}</p>
                @endif
            </div>
        </div>

        <div class="custom-control custom-checkbox mb-4">
            {{ Form::checkbox('remember', 1, false, ['class' => 'custom-control-input', 'id' => 'remember']) }}
            {{ Form::label('remember', __('login.remember_me'), ['class' => 'custom-control-label']) }}
        </div>

        <div class="flex items-center justify-between pt-4">
            {{ Form::button(__('login.submit'), ['type' => 'submit', 'class' => 'bg-primary hover:bg-black text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-all duration-200']) }}

            {{ Html::link('/password/reset', __('login.forgot_password'), ['class' => 'inline-block align-baseline font-bold text-primary hover:text-black transition-all duration-200']) }}
        </div>
    {{ Form::close() }}
</div>
