@extends('adminlte::page')

@section('title', 'FotoTool Userverwaltung')

@section('content_header')
    <h1 class="m-0 text-dark">Userverwaltung</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <form action="{{ route('users.update') }}" method="post">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Liste aller User</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>E-Mail</th>
                                <th>Rolle</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <select name="role_user_{{ $user->id }}" id="role_user_{{ $user->id }}" class="form-control">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" @if($user->hasRole($role)) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        @if($user->isNot(Auth::user()))
                                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">Löschen</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <form action="{{ route('user.store') }}" method="post">
                    @csrf
                <div class="card-header">
                    <h3 class="card-title">Neuen User anlegen</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name des Users</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email des Users</label>
                        <input type="email" name="email" placeholder="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Passwort des Users</label>
                        <input type="password" name="password" placeholder="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Rolle</label>
                        <select name="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">User anlegen</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@stop
