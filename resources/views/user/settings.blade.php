@extends('adminlte::page')

@section('title', 'FotoTool Userverwaltung')

@section('content_header')
    <h1 class="m-0 text-dark">Userverwaltung</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <form action="{{ route('usersettings.update') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Passwort ändern</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Altes Passwort</label>
                            <input name="oldpassword" type="password" class="form-control" id="name" placeholder="Altes Passwort">
                        </div>
                        <div class="form-group">
                            <label for="name">Neues Passwort</label>
                            <input name="password" type="password" class="form-control" id="name" placeholder="Neues Passwort">
                        </div>
                        <div class="form-group">
                            <label for="name">Neues Passwort bestätigen</label>
                            <input name="password_confirmation" type="password" class="form-control" id="name" placeholder="Altes Passwort">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
