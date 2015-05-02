@extends('layout.default')

@section('content')

    <form method="post">
        <div class="formplate">
            <label for="ModuleTitle">Title</label>
            <input id="ModuleTitle" type="text" name="title" value="{{ $module->title }}" />
        </div>
        <div class="formplate">
            <label for="ModuleHandle">Handle</label>
            <input id="ModuleHandle" type="text" name="handle" value="{{ $module->handle }}" />
        </div>
        <fieldset>
            <legend>Fields</legend>
            <div class="formplate">

            </div>
        </fieldset>
        <button class="button red">Save</button>
    </form>

@stop