@extends('layout.default')

@section('content')
    <h1>Singles</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Route</th>
            </tr>
        </thead>
        <tbody>
            @foreach($singles as $single)
                <tr>
                    <td><a href="{{ route('single-detail', ['id' => $single->id]) }}">{{ $single->title }}</a></td>
                    <td>{{ $single->handle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="btn btn-primary" href="{{ route('single-add') }}"><i class="fa fa-plus"></i> Add a Single</a>

@stop