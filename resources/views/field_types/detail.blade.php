<?php
$this->PlainText = $app->make('\App\Http\FieldTypes\PlainText');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($fieldType->id) ? 'Add' : 'Edit' }} a Field Type</h1>
    <form method="post">
        {!! $this->PlainText->render('title', ['value' => $fieldType->title]) !!}
        {!! $this->PlainText->render('handle', ['value' => $fieldType->handle]) !!}
        <button class="button red">Save</button>
    </form>

@stop