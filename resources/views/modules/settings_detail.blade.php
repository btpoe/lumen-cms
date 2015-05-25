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
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">Active Fields</div>
                    <ul class="list-group"
                        id="ActiveFields"
                        data-drag-container="master">
                        @foreach($activeFields as $field)
                            <li class="list-group-item"
                                data-group="{{ $field->group_id }}">
                                {{ $field->title }}
                                <input type="hidden" name="fields[]" value="{{ $field->id }}"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <button class="btn btn-danger">Save</button>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h2>Available Fields</h2>
            <p class="help-block">Drag items to the "Active Fields" container</p>
        </div>
        @foreach($fieldGroups as $group)
            <div class="col-md-3">
                <div class="panel panel-default">
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
            </div>
        @endforeach
    </div>

@stop