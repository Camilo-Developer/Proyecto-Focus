<?php

namespace App\Livewire\Admin\Visitors;

use App\Models\Visitor\Visitor;
use Livewire\Component;

class VisitorsFilter extends Component
{
    public $nameVisitors;
    public function render()
    {
        
        $visitors = Visitor::query()
        ->when($this->nameVisitors, function ($query){
            $query->where('name',  'like', '%' .$this->nameVisitors . '%');
        })
        ->when($this->nameVisitors, function ($query){
            $query->where('lastname',  'like', '%' .$this->nameVisitors . '%');
        })
        ->get();
                       
        return view('livewire.admin.visitors.visitors-filter');
        }
        public function applyFilters()
        {
        }
       
    
        public function removeFilter($filter)
        {
            switch ($filter) {
                case 'nameElements':
                    $this->nameVisitors = null;
                    break;
                }
        }
}
