<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        $people = Person::all();

        return view('people.index')->with(compact('people'));
    }

    public function show(Person $person)
    {
        return view('people.show')->with(compact('person'));
    }

    public function delete(Person $person)
    {
        $person->delete();

        flash('Die Person wurde erfolgreich gelöscht.');

        return redirect()->back();
    }
}
