{{ Form::open(['route' => $route, 'method' => 'delete', 'role' => 'form']) }}
    {{ Form::button(__('common.delete'), ['type' => 'submit', 'class' => 'btn btn-link btn-delete', 'data-confirm' => '']) }}
{{ Form::close() }}