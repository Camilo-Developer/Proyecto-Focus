<?php

namespace App\Livewire\Admin\ElementEntrys;

use App\Models\ElementEntry\Elemententry;
use GuzzleHttp\Psr7\Query;
use Livewire\Component;

class ElementEntryFilter extends Component
{
    public $nameElementsEntrys;
    public $elements;

    public function render()
    {
        $Elementsentrys = Elemententry::query()
            ->when($this->nameElementsEntrys, function ($query){
                $query->where('admission_date', 'like', '%' .$this->nameElementsEntrys . '%');
            })
            ->when($this->elements, function ($query){
                $query->where('departure_date', $this->nameElementsEntrys);
            })
            ->when($this->elements, function ($query){
                $query->where('note', $this->nameElementsEntrys);
            })
            ->when($this->elements, function ($query){
                $query->where('element_id', $this->nameElementsEntrys);
            })
            ->get();

        return view('livewire.admin.element-entrys.element-entry-filter');
    }

    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameElements':
                $this->nameElementsEntrys = null;
                break;
            case 'contractoremployeeElements':
                $this->elements = null;
                break;
        }
    }
}
