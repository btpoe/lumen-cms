@extends('layout.default')

@section('content')

    <h1>{{ empty($entry->id) ? 'Add' : 'Edit' }} {{ $module->classname }}</h1>
    <form class="row" method="post">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">General</div>
                <div class="panel-body">
                    @foreach($fields as $field)
                        {!! $fieldTypes[$field->type_id]->render($field->handle, json_decode($field->settings, true) + ['value' => $entry->{$field->handle}]) !!}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <button class="btn btn-danger">Save</button>
        </div>
    </form>

@stop