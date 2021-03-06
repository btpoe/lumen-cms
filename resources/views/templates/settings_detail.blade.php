<?php
$this->PlainText = $app->make('\App\CMS\FieldTypes\PlainText');
?>

@extends('layout.default')

@section('content')

    <h1>{{ empty($field->id) ? 'Add' : 'Edit' }} Template</h1>
    <form class="row" method="post">
        <div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">General</div>
                <div class="panel-body">
                    {!! $this->PlainText->render('title', ['value' => $template->title]) !!}
                    {!! $this->PlainText->render('handle', ['value' => $template->handle]) !!}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
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
        <div class="col-sm-12">
            <button class="btn btn-danger">Save</button>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12">
            <h2>Available Fields</h2>
            <p class="help-block">Drag items to the "Active Fields" container</p>
        </div>
        @foreach($fieldGroups as $group)
            <div class="col-xs-12 col-sm-6 col-md-4">
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