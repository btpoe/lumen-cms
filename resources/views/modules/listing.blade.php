@extends('layout.default')

@section('content')
    <h1>{{ $module->title }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td><a href="{{ route('module-detail', ['handle' => $module->handle, 'id' => $entry->id]) }}">{{ $entry->title }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route('module-add', ['handle' => $module->handle]) }}"><i class="fa fa-plus"></i> Add an Entry</a>

@stop