<?php
$this->PlainText = $app->make('\App\CMS\FieldTypes\PlainText');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($field->id) ? 'Add' : 'Edit' }} a Module</h1>
    <form method="post">
        {!! $this->PlainText->render('title', ['value' => $module->title]) !!}
        {!! $this->PlainText->render('handle', ['value' => $module->handle]) !!}
        <div class="row">
            <div class="well is-active">
                <div class="well-heading">Active Fields</div>
                <ul id="ActiveFields" data-drag-container="master">
                    @foreach($activeFields as $field)
                        <li class="well-card" data-group="{{ $field->group_id }}">
                            {{ $field->title }}
                            <input type="hidden" name="fields[]" value="{{ $field->id }}"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button class="btn btn-danger">Save</button>
    </form>
    <div class="row">
        <div>Available Fields</div>
        @foreach($fieldGroups as $group)
            <div class="panel">
                <div class="panel-heading">{{ $group->title }}</div>
                <ul class="list-group"
                    id="AvailableFields{{ $group->id }}"
                    data-drag-container="slave"
                    data-group="{{ $group->id }}">
                    @foreach((array) $fields->get($group->id) as $field)
                        <li class="list-group-item"
                            data-group="{{ $group->id }}">
                            {{ $field->title }}
                            <input type="hidden" name="fields[]" value="{{ $field->id }}"/>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

@stop