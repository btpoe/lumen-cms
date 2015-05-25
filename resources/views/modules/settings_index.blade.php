@extends('layout.default')

@section('content')
    <h1>Modules</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Handle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modules as $module)
                <tr>
                    <td><a href="{{ route('settings-module-detail', ['id' => $module->id]) }}">{{ $module->title }}</a></td>
                    <td>{{ $module->handle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route('settings-module-add') }}"><i class="fa fa-plus"></i> Add a Module</a>

@stop