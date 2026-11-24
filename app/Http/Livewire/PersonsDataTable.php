<?php

namespace App\Http\Livewire;

use App\Models\Person;
use App\Models\Tag;
use Livewire\Component;

class PersonsDataTable extends Component
{
    /**
     * @var string
     */
    public string $searchQuery='';

    /**
     * @var \Illuminate\Support\Collection
     */
    public $persons;

    public function search()
    {
        if (empty($this->searchQuery)){
            $this->persons = Person::all();
        } else {
            $this->persons = Person::query()
                ->where('name', 'like', '%' . $this->searchQuery . '%')
                ->get();
        }
    }

    public function render()
    {
        $this->search();
        return view('livewire.persons-data-table');
    }
}
