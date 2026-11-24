@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">Kanäle</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste aller Kanäle</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Kanal</th>
                            <th>Anzahl der Dateien</th>
                            <th>Aktion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($platforms as $platform)
                            <tr>
                                <td>{{ $platform->name }}</td>
                                <td>{{ $platform->files->count() }}</td>
                                <td>
                                    <a href="{{ route('platform.show', $platform) }}" class="btn btn-sm btn-primary">Details</a>
                                    @can('delete publications')
                                    <a href="{{ route('platform.delete', $platform) }}" class="btn btn-sm btn-danger">Löschen</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
