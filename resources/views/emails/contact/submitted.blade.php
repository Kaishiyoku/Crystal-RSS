@component('mail::message')
    {{ trans('validation.attributes.email') }}: {{ $email }}<br/>
    {{ trans('validation.attributes.name') }}: {{ $name }}<br/>

    {{ trans('validation.attributes.content') }}:<br/>

    <pre>{{ $content }}</pre>
@endcomponent
