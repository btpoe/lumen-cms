<?php
$this->PlainText = $app->make('\App\CMS\FieldTypes\PlainText');
$this->Dropdown = $app->make('\App\CMS\FieldTypes\Dropdown');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($single->id) ? 'Add' : 'Edit' }} Single</h1>
    <form id="EntryForm" class="row" method="post">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">General</div>
                <div class="panel-body">
                    {!! $this->PlainText->render('title', ['maxlength' => 255, 'value' => $single->title]) !!}
                    {!! $this->PlainText->render('handle', ['maxlength' => 255, 'value' => $single->handle]) !!}
                    {!! $this->Dropdown->render('template_id', ['id' => 'EntryType', 'options' => $templates->lists('title', 'id'), 'value' => $single->template_id]) !!}
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Settings</div>
                <div class="panel-body"
                     id="EntrySettings"
                     data-type="templates"
                     data-settings="{{ $entrySettings }}"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Meta Data</div>
            </div>
        </div>
        <div class="col-sm-12">
            <button class="btn btn-danger">Save</button>
        </div>
    </form>

@stop