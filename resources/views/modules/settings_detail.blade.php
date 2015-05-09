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