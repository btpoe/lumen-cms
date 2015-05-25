@extends('layout.default')

@section('content')
    <h1>Modules</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modules as $module)
                <tr>
                    <td><a href="{{ route('module-list', ['handle' => $module->handle]) }}">{{ $module->title }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop