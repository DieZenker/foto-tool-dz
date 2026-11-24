@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Album anlegen</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('album.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="description">Beschreibung</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Beschreibung"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
