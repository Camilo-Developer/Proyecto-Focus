<?php

namespace App\Livewire\Admin\Elements;

use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\Element\Element;
use Livewire\Component;

class ElementsFilter extends Component
{

    public $nameElements;
    public $contractoremployeeElements;

    public function render()
    {

        $contractoremployees = Contractoremployee::all();

        $elements = Element::query()
                    ->when($this->nameElements, function ($query){
                        $query->where('name',  'like', '%' .$this->nameElements . '%');
                    })
                    ->when($this->contractoremployeeElements, function ($query) {
                        $query->where('contractoremployee_id', $this->contractoremployeeElements);
                    })
                    ->get();

        return view('livewire.admin.elements.elements-filter',compact('contractoremployees','elements'));
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
            case 'contractoremployeeElements':
                $this->contractoremployeeElements = null;
                break;
        }
    }
}
