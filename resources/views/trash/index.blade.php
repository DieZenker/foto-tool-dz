@extends('adminlte::page')

@section('title', 'Papierkorb')

@section('content_header')
    <h1 class="m-0 text-dark">Papierkorb</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gelöschte Alben</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Datum</th>
                                <th>Aktion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($albums as $album)
                                <tr>
                                    <td>{{ $album->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($album->deleted_at)->format('d.m.Y') }}</td>
                                    <td><a href="{{ route('album.restore', $album) }}" class="btn btn-info btn-sm">Wiederherstellen</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">Gelöschte Dateien</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Vorschau</th>
                                <th>Name</th>
                                <th>Datum</th>
                                <th>Aktion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        @if(File::extension($file->file) == 'xls' || File::extension($file->file) == 'xlsx')
                                            <img style="max-width: 100px;" src="{{ asset('img/icons/xls.png') }}" alt="{{ $file->name }}">
                                        @elseif(File::extension($file->file) == 'pdf')
                                            <img style="max-width: 100px;" src="{{ asset('img/icons/pdf.png') }}" alt="{{ $file->name }}">
                                        @else
                                            <img style="max-width: 100px;" src="{{ route('file.download', $file) }}" alt="{{ $file->name }}">
                                        @endif
                                    </td>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($file->deleted_at)->format('d.m.Y') }}</td>
                                    <td><a href="{{ route('file.restore', $file) }}" class="btn btn-info btn-sm">Wiederherstellen</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@stop
