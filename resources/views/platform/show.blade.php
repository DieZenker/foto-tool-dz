@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $platform->name }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dateien auf diesem Kanal</h3>
                </div>
                <div class="card-body p-0">
                    <livewire:file-list :files="$platform->files" />
                </div>
            </div>
        </div>
    </div>

@stop
