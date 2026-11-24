@extends('adminlte::page')

@section('title', 'FotoTool')

@section('content_header')
    <h1 class="m-0 text-dark">{{ $tag->title }}</h1>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dateien zu diesem Tag</h3>
                </div>
                <div class="card-body p-0">
                    <livewire:file-list :files="$tag->files" />
                </div>
            </div>
        </div>
    </div>

@stop
