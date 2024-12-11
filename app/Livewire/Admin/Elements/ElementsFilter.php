<?php

namespace App\Livewire\Admin\Elements;

use App\Models\Element\Element;
use Livewire\Component;

class ElementsFilter extends Component
{

    public $nameElements;

    public function render()
    {


        $elements = Element::query()
                    ->when($this->nameElements, function ($query){
                        $query->where('name',  'like', '%' .$this->nameElements . '%');
                    })
                    ->get();

        return view('livewire.admin.elements.elements-filter',compact('elements'));
    }

    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameElements':
                $this->nameElements = null;
                break;
        }
    }
}
