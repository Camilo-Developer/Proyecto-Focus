<?php

namespace App\Livewire\Admin\Visitors;

use App\Models\Visitor\Visitor;
use Livewire\Component;
use Livewire\WithPagination;


class VisitorsFilter extends Component
{
    use WithPagination;

    public $nameVisitors;
    public $phoneVisitors;
    public $documentNumberVisitors;
    public $confirmationVisitors;
    
    public function render()
    {
        if (auth()->user()->can('admin.permission.administrator')) {
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
            ->paginate(10);
               
            return view('livewire.admin.visitors.visitors-filter',compact('visitors'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();
        
            $visitors = Visitor::query()->where('setresidencial_id',$setresidencial->id)
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
                    ->paginate(10);
                       
            return view('livewire.admin.visitors.visitors-filter',compact('visitors'));
        }
        elseif (auth()->user()->can('admin.permission.goalie')) {

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();
        
            $visitors = Visitor::query()->where('setresidencial_id',$setresidencial->id)
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
                    ->paginate(10);
                       
            return view('livewire.admin.visitors.visitors-filter',compact('visitors'));
            
        }
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
