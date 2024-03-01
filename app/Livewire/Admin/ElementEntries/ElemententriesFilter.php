<?php

namespace App\Livewire\Admin\ElementEntries;

use App\Models\Element\Element;
use App\Models\ElementEntry\Elemententry;
use Livewire\Component;

class ElemententriesFilter extends Component
{
    public $dateInitElementEntries;
    public $dateFinishElementEntries;

    public $elementIDElementEntries;

    public function render()
    {
        $elements = Element::all();
        $elementEntries = Elemententry::query()
            ->when($this->dateInitElementEntries, function ($query){
                $query->where('admission_date',  'like', '%' .$this->dateInitElementEntries . '%');
            })
            ->when($this->dateFinishElementEntries, function ($query){
                $query->where('departure_date',  'like', '%' .$this->dateFinishElementEntries . '%');
            })
            ->when($this->elementIDElementEntries, function ($query) {
                $query->where('element_id', $this->elementIDElementEntries);
            })
            ->get();

        return view('livewire.admin.element-entries.elemententries-filter',compact('elements','elementEntries'));
    }

    public function applyFilters()
    {
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'dateInitElementEntries':
                $this->dateInitElementEntries = null;
                break;
            case 'dateFinishElementEntries':
                $this->dateFinishElementEntries = null;
                break;
            case 'elementIDElementEntries':
                $this->elementIDElementEntries = null;
                break;
        }
    }
}
