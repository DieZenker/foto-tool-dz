<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::all();

        return view('platform.index')->with(compact('platforms'));
    }

    public function show(Platform $platform)
    {
        return view('platform.show')->with(compact('platform'));
    }

    public function delete(Platform $platform)
    {
        $platform->delete();

        return redirect()->back();
    }
}
