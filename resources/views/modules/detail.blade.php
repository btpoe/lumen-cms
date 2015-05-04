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
        <div class="row">
            <div>Active Fields</div>
            <div class="span-6">
                <ul id="ActiveFields" data-drag-container="master">
                    @foreach($activeFields as $field)
                        <li class="input-card" data-group="{{ $field->group_id }}">
                            {{ $field->title }}
                            <input type="hidden" name="fields[]" value="{{ $field->id }}"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button class="button red">Save</button>
    </form>
    <div class="row">
        <div>Available Fields</div>
        @foreach($fieldGroups as $group)
            <div class="span-6 pad-l-10 pad-r-10">
                <div>{{ $group->title }}</div>
                <ul id="AvailableFields{{ $group->id }}" data-drag-container="slave" data-group="{{ $group->id }}">
                    @foreach((array) $fields->get($group->id) as $field)
                        <li class="input-card" data-group="{{ $group->id }}">
                            {{ $field->title }}
                            <input type="hidden" name="fields[]" value="{{ $field->id }}"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

@stop