<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $files = File::onlyTrashed()->get();
        $albums = Album::onlyTrashed()->get();

        return view('trash.index', compact('albums', 'files'));
    }
}
