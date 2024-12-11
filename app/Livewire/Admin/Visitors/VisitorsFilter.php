<?php

namespace App\Livewire\Admin\Visitors;

use App\Models\Visitor\Visitor;
use Livewire\Component;

class VisitorsFilter extends Component
{
    public $nameVisitors;
    public $phoneVisitors;
    public $documentNumberVisitors;
    public $confirmationVisitors;
    
    public function render()
    {
        
        $visitors = Visitor::query()
                    ->when($this->nameVisitors, function ($query){
                        $query->where('name',  'like', '%' .$this->nameVisitors . '%');
                    })
                    ->when($this->phoneVisitors, function ($query){
                        $query->where('phone',  'like', '%' .$this->phoneVisitors . '%');
                    })
                    ->when($this->documentNumberVisitors, function ($query){
                        $query->where('document_number',  'like', '%' .$this->documentNumberVisitors . '%');
                    })
                    ->when($this->confirmationVisitors, function ($query){
                        $query->where('confirmation',  'like', '%' .$this->confirmationVisitors . '%');
                    })
                    ->get();
                       
        return view('livewire.admin.visitors.visitors-filter',compact('visitors'));
        }
        public function applyFilters()
        {
        }
       
    
        public function removeFilter($filter)
        {
            switch ($filter) {
                case 'nameVisitors':
                    $this->nameVisitors = null;
                    break;
                case 'phoneVisitors':
                    $this->phoneVisitors = null;
                    break;
                case 'documentNumberVisitors':
                    $this->documentNumberVisitors = null;
                    break;
                case 'confirmationVisitors':
                    $this->confirmationVisitors = null;
                    break;
                
                }
        }
}
