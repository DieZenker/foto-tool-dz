@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')

    <div class="row">
        @foreach($albums as $album)
            <div class="col-lg-2 col-md-3 col-sm-6">
                <a href="{{ route('album.show', $album) }}" class="album-info-box text-gray-dark">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="far fa-folder"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{ $album->name }}</span>
                            <span class="info-box-text">Album</span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Zuletzt verwendete Dateien</h3>
                </div>
                <div class="card-body p-0">
                    <livewire:file-list :files="$files" />
                </div>
            </div>
        </div>
    </div>
@stop
