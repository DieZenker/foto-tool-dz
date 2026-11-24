<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!\Auth::user()->can('edit users'), 403);

        $users = User::all();
        $roles = Role::all();
        return view('user.index')->with(compact('users', 'roles'));
    }

    public function update(Request $request)
    {
        abort_if(!\Auth::user()->can('edit users'), 403);

        $users = User::all();

        foreach ($users as $user) {
            $newRoleId = $request->input('role_user_' . $user->id);
            $newRole = Role::find($newRoleId);
            if (!$user->hasRole($newRole)) {
                $userRoles = $user->roles;
                foreach ($userRoles as $userRole) {
                    $user->removeRole($userRole);
                }
                $user->assignRole($newRole);
            }
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        abort_if(!\Auth::user()->can('edit users'), 403);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:App\Models\User,email',
            'role_id' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => \Hash::make($request->input('password'))
        ]);

        $user->assignRole($request->input('role_id'));

        flash('Der User wurde erfolgreich angelegt.', 'success');

        return redirect()->back();
    }

    public function delete(User $user)
    {
        $user->delete();
        flash('Der Nutzer wurde erfolgreich deaktiviert.');
        return redirect()->back();
    }
}
