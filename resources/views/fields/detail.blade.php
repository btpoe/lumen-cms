<?php
$this->PlainText = $app->make('\App\Http\FieldTypes\PlainText');
$this->Dropdown = $app->make('\App\Http\FieldTypes\Dropdown');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($field->id) ? 'Add' : 'Edit' }} Field</h1>
    <form id="FieldForm" method="post">
        {!! $this->Dropdown->render('group_id', ['title' => 'Group', 'options' => $fieldGroups->lists('title', 'id'), 'selected' => $field->group_id]) !!}
        {!! $this->PlainText->render('title', ['value' => $field->title]) !!}
        {!! $this->PlainText->render('handle', ['value' => $field->handle]) !!}
        {!! $this->PlainText->render('instructions', ['value' => $field->instructions]) !!}
        {!! $this->Dropdown->render('type_id', ['title' => 'Type', 'id' => 'FieldType', 'options' => $fieldTypes->lists('title', 'id'), 'selected' => $field->type_id]) !!}
        <label for="FieldTypeSettings">Settings</label>
        <div id="FieldTypeSettings" data-settings="{{ $field->settings }}"></div>
        <button class="button red">Save</button>
    </form>

@stop