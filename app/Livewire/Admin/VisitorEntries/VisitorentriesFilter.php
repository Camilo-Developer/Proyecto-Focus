<?php

namespace App\Livewire\Admin\VisitorEntries;

use App\Models\State\State;
use App\Models\Unit\Unit;
use App\Models\VisitorEntry\Visitorentry;
use Livewire\Component;

class VisitorentriesFilter extends Component
{
    public $admissiondateVisitors;
    public $departuredateVisitors;
    public $unitVisitors;
    public $stateVisitors;

    public function render()
    {
        $units =Unit::all();
        $states = State::all();
        $visitorentries = Visitorentry::query()
            ->when($this->admissiondateVisitors, function ($query){
                $query->where('admission_date',  'like', '%' .$this->admissiondateVisitors . '%');
            })
            ->when($this->departuredateVisitors, function ($query){
                $query->where('departure_date',  'like', '%' .$this->departuredateVisitors . '%');
            })
            ->when($this->unitVisitors, function ($query) {
                $query->where('unit_id', $this->unitVisitors);
            })
            ->when($this->stateVisitors, function ($query) {
                $query->where('state_id', $this->stateVisitors);
            })
            ->get();

        return view('livewire.admin.visitor-entries.visitorentries-filter',compact('units','states','visitorentries'));
    }
    public function applyFilters()
    {
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'admissiondateVisitors':
                $this->admissiondateVisitors = null;
                break;
            case 'departuredateVisitors':
                $this->departuredateVisitors = null;
                break;
            case 'unitVisitors':
                $this->unitVisitors = null;
                break;
            case 'stateVisitors':
                $this->stateVisitors = null;
                break;
        }
    }
}
