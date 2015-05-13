@foreach($fields as $field)
    {!! $fieldTypes[$field->type_id]->render($field->handle, json_decode($field->settings, true)) !!}
@endforeach