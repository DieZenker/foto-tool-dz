@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">Album</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste aller Alben</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Anzahl der Dateien</th>
                            <th>Erstellt</th>
                            <th>Aktion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($albums as $album)
                            <tr>
                                <td>{{ $album->name }}</td>
                                <td>{{ $album->files->count() }}</td>
                                <td>{{ \Carbon\Carbon::parse($album->created_at)->format('d.m.Y') }}</td>
                                <td>
                                    <a href="{{ route('album.show', $album) }}" class="btn btn-sm btn-primary">Details</a>
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
