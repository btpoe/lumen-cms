<?php
$this->PlainText = $app->make('\App\CMS\FieldTypes\PlainText');
$this->Dropdown = $app->make('\App\CMS\FieldTypes\Dropdown');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($field->id) ? 'Add' : 'Edit' }} a Field</h1>
    <form id="EntryForm" method="post">
        {!! $this->Dropdown->render('group_id', ['options' => $fieldGroups->lists('title', 'id'), 'value' => $field->group_id]) !!}
        {!! $this->PlainText->render('title', ['maxlength' => 255, 'value' => $field->title]) !!}
        {!! $this->PlainText->render('handle', ['maxlength' => 255, 'value' => $field->handle]) !!}
        {!! $this->PlainText->render('instructions', ['value' => $field->instructions]) !!}
        {!! $this->Dropdown->render('type_id', ['id' => 'EntryType', 'options' => $fieldTypes->lists('title', 'id'), 'value' => $field->type_id]) !!}
        <label for="EntrySettings">Settings</label>
        <div id="EntrySettings" data-type="field-types" data-settings="{{ $field->settings }}"></div>
        <button class="button red">Save</button>
    </form>

@stop