<?php

namespace App\Http\Livewire;

use App\Models\Album;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileUploader extends Component
{
    use WithFileUploads;

    public $files = [];
    public $album = null;
    public $tags = [];

    public function mounted(Album $album)
    {
        $this->album = $album;
    }

    public function save()
    {
        foreach ($this->files as $file) {
            $filePath = $file->store('', 'uploads');
            $fullFilePath = storage_path('app/uploads/' . $filePath);

            //Create Thumbnail
            /*$thumb = Image::make($fullFilePath);
            $thumb->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $extension = \File::extension($filePath);
            $thumbName = \Str::random() . '_thumb.' . $extension;
            $thumb->save(storage_path('app/uploads/' . $thumbName));*/
            $extension = \File::extension($filePath);
            $thumbName = \Str::random() . '_thumb.' . $extension;
            $fullThumbPath = storage_path('app/uploads/' . $thumbName);
            try {
                createThumbnail($fullFilePath, $fullThumbPath);
            } catch (\Exception $ex) {
                // DO nothing
                $thumbName = null;
            }


            $file = File::create([
                'name' => $file->getClientOriginalName(),
                'file' => $filePath,
                'thumbnail' => $thumbName,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'album_id' => $this->album->id
            ]);
            foreach ($this->tags as $tag) {
                $file->addTag($tag);
            }
        }
        flash('Die Dateien wurden erfolgreich hochgeladen.', 'success', 'check');
        return redirect()->route('album.show', $this->album);
    }

    public function remove($index)
    {
        if (count($this->files) > 1)
            array_splice($this->files, $index, 1);
        else {
            $this->files = [];
            return redirect()->route('album.show', $this->album);
        }
    }

    public function render()
    {
        return view('livewire.file-uploader');
    }
}
