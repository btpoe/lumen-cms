@extends('layout.default')

@section('content')

    <h1>Fields</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Handle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fieldTypes as $fieldType)
                <tr>
                    <td><a href="{{ route('settings-field-type-detail', ['id' => $fieldType->id]) }}">{{ $fieldType->title }}</a></td>
                    <td>{{ $fieldType->handle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route('settings-field-type-add') }}"><i class="fa fa-plus"></i> Add a Field Type</a>

@stop