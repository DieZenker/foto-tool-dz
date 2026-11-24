<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $albums = Album::query()->limit(6)->orderBy('updated_at', 'desc')->get();
        $files = File::query()->orderBy('created_at', 'desc')->limit(25)->get();
        return view('dashboard')->with(compact('albums' , 'files'));
    }
}
