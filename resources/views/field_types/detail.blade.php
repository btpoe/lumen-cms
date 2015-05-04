@extends('layout.default')

@section('content')

    <h1>{{ empty($fieldType->id) ? 'Add' : 'Edit' }} Field Type</h1>
    <form method="post">
        <div class="formplate">
            <label for="FieldTitle">Title</label>
            <input id="FieldTitle" type="text" name="title" value="{{ $fieldType->title }}" />
        </div>
        <div class="formplate">
            <label for="FieldHandle">Handle</label>
            <input id="FieldHandle" type="text" name="handle" value="{{ $fieldType->handle }}" />
        </div>
        <button class="button red">Save</button>
    </form>

@stop