<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tag.index')->with(compact('tags'));
    }

    public function show(Tag $tag)
    {
        return view('tag.show')->with(compact('tag'));
    }

    public function delete(Tag $tag)
    {
        $tag->delete();

        return redirect()->back();
    }
}
