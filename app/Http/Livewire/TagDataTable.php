<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;

class TagDataTable extends Component
{
    /**
     * @var string
     */
    public string $searchQuery='';

    /**
     * @var \Illuminate\Support\Collection
     */
    public $tags;

    public function search()
    {
        if (empty($this->searchQuery)){
            $this->tags = Tag::all();
        } else {
            $this->tags = Tag::query()
                ->where('title', 'like', '%' . $this->searchQuery . '%')
                ->get();
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->search();
        return view('livewire.tag-data-table');
    }
}
