<?php

namespace App\Livewire\Admin\Shifts;

use App\Models\SetResidencial\Setresidencial;
use App\Models\Shifts\Shifts;
use App\Models\State\State;
use Livewire\Component;

class ShiftsFilter extends Component
{
    public $nameShifts;
    public $stateShifts;
    public $setresidencialShifts;

    public function render()
    {
        $states = State::all();
        $setresidencials = Setresidencial::all();
        $shifts = Shifts::query()
            ->when($this->nameShifts, function ($query){
                $query->where('name',  'like', '%' .$this->nameShifts . '%');
            })
            ->when($this->stateShifts, function ($query) {
                $query->where('state_id', $this->stateShifts);
            })
            ->when($this->setresidencialShifts, function ($query) {
                $query->where('setresidencial_id', $this->setresidencialShifts);
            })
            ->get();

        return view('livewire.admin.shifts.shifts-filter',compact('states','setresidencials','shifts'));
    }
    public function applyFilters()
    {
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameShifts':
                $this->nameShifts = null;
                break;
            case 'stateShifts':
                $this->stateShifts = null;
                break;
            case 'setresidencialShifts':
                $this->setresidencialShifts = null;
                break;
        }
    }
}
