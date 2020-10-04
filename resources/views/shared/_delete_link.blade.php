{{ Form::open(['route' => $route, 'method' => 'delete', 'role' => 'form', 'class' => 'inline-block']) }}
    {{ Form::button($title ?? __('common.delete'), ['type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'data-confirm' => '']) }}
{{ Form::close() }}
