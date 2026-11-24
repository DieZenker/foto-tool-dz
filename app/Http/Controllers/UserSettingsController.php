<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('user.settings')->with(compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = Auth::user();

        $checked = \Hash::check($request->oldpassword, $user->password);
        if (!$checked) {
            flash('Das alte Passwort ist leider nicht korrekt! Das neue Passwort wurde NICHT gesetzt.', 'danger');
            return redirect()->back();
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        flash('Das neue Passwort wurde erfolgreich gespeichert.', 'success');
        return redirect()->back();
    }
}
