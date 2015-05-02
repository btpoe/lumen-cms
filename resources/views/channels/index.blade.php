@extends('layout.default')

@section('content')
    <h1>Channels</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Handle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($channels as $channel)
                <tr>
                    <td><a href="{{ route('channel-detail', ['id' => $channel->id]) }}">{{ $channel->title }}</a></td>
                    <td>{{ $channel->handle }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a class="button green" href="{{ route('channel-add') }}"><i class="fa fa-plus"></i> Add a Channel</a>

@stop