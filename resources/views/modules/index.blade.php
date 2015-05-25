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
            @foreach($modules as $moduleHandle => $moduleClassName)
                <tr>
                    <td><a href="{{ route('module-list', ['handle' => $moduleHandle]) }}">{{ Doctrine\Common\Inflector\Inflector::pluralize($moduleClassName) }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop