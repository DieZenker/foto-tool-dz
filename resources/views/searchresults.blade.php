@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">Suchergebnisse</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Alben</h3>
                </div>
                <div class="card-body">
                    @if(!$albums->count())
                        Es wurden keine Alben gefunden
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Anzahl an Dateien</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($albums as $album)
                                <tr>
                                    <td>{{ $album->name }}</td>
                                    <td>{{ $album->files->count() }}</td>
                                    <td>
                                        <a href="{{ route('album.show', $album) }}" class="btn btn-xs btn-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dateien</h3>
                </div>
                <div class="card-body">
                    @if(!$files->count())
                        Es wurden keine Dateien gefunden
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Zuletzt geändert</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <a href="{{ route('file.show', $file) }}">
                                            <img style="max-width: 100px;" src="{{ route('file.download', $file) }}" alt="{{ $file->name }}">
                                        </a>
                                    </td>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($file->updated_at)->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{ route('file.show', $file) }}" class="btn btn-xs btn-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personen</h3>
                </div>
                <div class="card-body">
                    @if(!$people->count())
                        Es wurden keine Personen gefunden
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($people as $person)
                                <tr>
                                    <td>
                                        <a href="{{ route('people.show', $person) }}">
                                            {{ $person->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('people.show', $person) }}" class="btn btn-xs btn-primary">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
