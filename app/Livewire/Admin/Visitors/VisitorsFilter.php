<?php

namespace App\Livewire\Admin\Visitors;

use App\Models\Visitor\Visitor;
use Livewire\Component;

class VisitorsFilter extends Component
{
    public $nameVisitors;
    public $lastnameVisitors;
    
    public function render()
    {
        
        $visitors = Visitor::query()
                    ->when($this->nameVisitors, function ($query){
                        $query->where('name',  'like', '%' .$this->nameVisitors . '%');
                    })
                    ->when($this->lastnameVisitors, function ($query){
                        $query->where('lastname',  'like', '%' .$this->lastnameVisitors . '%');
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
                case 'nameElements':
                    $this->nameVisitors = null;
                    break;
                case 'lastnameVisitors':
                    $this->lastnameVisitors = null;
                    break;
                
                }
        }
}
