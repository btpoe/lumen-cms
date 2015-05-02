@extends('layout.default')

@section('content')

    <h1>Fields</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fields as $field)
                <tr>
                    <td><a href="{{ route('field-detail', ['id' => $field->id]) }}">{{ $field->title }}</a></td>
                    <td>{{ $field->type_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="button green" href="{{ route('field-add') }}"><i class="fa fa-plus"></i> Add a Field</a>

@stop