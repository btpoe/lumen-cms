@extends('layout.default')

@section('content')

    <h1>{{ empty($entry->id) ? 'Add' : 'Edit' }} {{ $module->entry_title }}</h1>
    <form method="post">
        {!! $fieldTypes[PLAIN_TEXT_ID]->render('title', ['value' => $entry->title]) !!}
        @foreach($fields as $field)
            {!! $fieldTypes[$field->type_id]->render($field->handle, json_decode($field->settings, true) + ['value' => $entry->{$field->handle}]) !!}
        @endforeach
        <button class="btn btn-danger">Save</button>
    </form>

@stop