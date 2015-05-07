@extends('layout.default')

@section('content')
    <h1>Modules</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $entry)
                <tr>
                    <td><a href="{{ route('module-detail', ['handle' => $handle, 'id' => $entry->id]) }}">{{ $entry->title }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="button green" href="{{ route('module-add', ['handle' => $handle]) }}"><i class="fa fa-plus"></i> Add an Entry</a>

@stop