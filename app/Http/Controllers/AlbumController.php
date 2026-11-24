<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AlbumController extends Controller
{

    public function index()
    {
        $albums = Album::all();
        return view('album.index')->with(compact('albums'));
    }

    public function create()
    {
        $firstLevelAlbums = Album::whereNull('parent_id')->get();
        return view('album.create')->with(compact('firstLevelAlbums'));
    }

    public function show(Album $album)
    {
        return view('album.show')->with(compact('album'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'string|nullable',
            'parent_album_id' => 'integer|nullable'
        ]);

        $album = Album::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'parent_id' => $request->has('parent_id') ? $request->input('parent_id') : null,
            'user_id' => Auth::user()->id
        ]);

        flash('Das Album wurde erfolgreich angelegt.', 'success', 'check');

        return redirect()->route('album.show', $album);
    }

    public function upload(Request $request)
    {
        if (!$request->has('uploads'))
            return redirect()->back()->withErrors('Keine Dateien zum Uploaden bereitgestellt.');

        foreach ($request->uploads as $upload) {
            $filePath = $upload->store('', 'uploads');
            $file = File::create([
                'name' => $upload->getClientOriginalName(),
                'file' => $filePath,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'album_id' => $request->input('album_id')
            ]);
            \fileLog('Datei wurde hochgeladen.', $file);
        }

        return redirect()->back();
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ]);

        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->save();

        flash('Die Daten zum Album wurden geändert', 'success');

        return redirect()->route('album.show', $album);
    }

    public function download(Album $album)
    {
        $zipFile = $album->name . '.zip';
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addEmptyDir($album->name);

        foreach ($album->files as $file) {
            $zip->addFile(Storage::disk('uploads')->path($file->file), $album->name . '/' . $file->name);
        }

        $zip->close();

        return response()->download($album->name . '.zip');
    }

    public function move(Album $album, Request $request)
    {
        $request->validate([
            'parent_album_id' => 'required'
        ]);

        $parentAlbum = Album::find($request->input('parent_album_id'));
        if (is_null($parentAlbum) && $request->input('parent_album_id') == '0')
            $parentId = null;
        else
            $parentId = $parentAlbum->id;

        $album->parent_id = $parentId;
        $album->save();

        flash('Das Album wurde erfolgreich verschoben.', 'success');

        return redirect()->route('album.show', $album);
    }

    public function delete(Album $album)
    {
        $files = $album->files;
        $album->delete();

        foreach ($files as $file)
        {
            $file->delete();
        }

        flash('Das ALbum wurde erfolgreich gelöscht.', 'success');

        return redirect()->route('album.index');
    }

    public function restore($album)
    {
        $album = Album::onlyTrashed()->find($album);
        $album->restore();

        $files = File::onlyTrashed()->where('album_id', $album->id)->get();
        foreach ($files as $file)
        {
            if ($file->trashed())
                $file->restore();
        }

        flash('Das Album inkl. Dateien wurde wiederhergestellt.', 'success');

        return redirect()->back();
    }
}
