<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $searchQuery = $request->input('search');

        $files = \App\Models\File::where('name', 'like', '%' . $searchQuery . '%')->get();
        $people = \App\Models\Person::where('name', 'like', '%' . $searchQuery . '%')->get();
        $albums = \App\Models\Album::where('name', 'like', '%' . $searchQuery . '%')->get();

        return view('searchresults')->with(compact(['files', 'albums', 'people']));
    }
}
