@extends('layout.default')

@section('content')

    <h1>{{ empty($field->id) ? 'Add' : 'Edit' }} Field</h1>
    <form method="post">
        <div class="formplate">
            <label for="FieldGroup">Group</label>
            <select name="group_id" id="FieldGroup">
                @foreach($fieldGroups as $group)
                    <option value="{{ $group->id }}" @if($field->group_id == $group->id) selected @endif>{{ $group->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="formplate">
            <label for="FieldTitle">Title</label>
            <input id="FieldTitle" type="text" name="title" value="{{ $field->title }}" />
        </div>
        <div class="formplate">
            <label for="FieldHandle">Handle</label>
            <input id="FieldHandle" type="text" name="handle" value="{{ $field->handle }}" />
        </div>
        <div class="formplate">
            <label for="FieldInstructions">Instructions</label>
            <input id="FieldInstructions" type="text" name="instructions" value="{{ $field->instructions }}" />
        </div>
        <div class="formplate">
            <label for="FieldType">Type</label>
            <select name="type_id" id="FieldType" style="width: 100%">
                @foreach($fieldTypes as $type)
                    <option value="{{ $type->id }}" @if($field->type_id == $type->id) selected @endif>{{ $type->title }}</option>
                @endforeach
            </select>
        </div>
        <fieldset>
            <legend>Settings</legend>
            <div id="FieldTypeSettings" data-settings="{{ $field->settings }}"></div>
        </fieldset>
        <button class="button red">Save</button>
    </form>

@stop