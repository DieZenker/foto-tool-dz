<?php

namespace App\Http\Livewire;

use App\Models\Album;
use App\Models\File;
use Livewire\Component;

class FileList extends Component
{
    public $files;
    public $subAlbums;

    public function __construct($files=null, $subAlbums=null)
    {
        $this->files = $files;
        if (is_null($this->files))
            $this->files = collect();

        $this->subAlbums = $subAlbums;
        if (is_null($this->subAlbums))
            $this->subAlbums = collect();
    }

    public function render()
    {
        return view('livewire.file-list');
    }
}
