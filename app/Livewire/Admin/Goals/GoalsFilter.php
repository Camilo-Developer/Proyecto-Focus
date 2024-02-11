<?php

namespace App\Livewire\Admin\Goals;


use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Livewire\Component;

class GoalsFilter extends Component
{
    
    public $nameGoals;
    public $stateGoals;
    public $setresidencialGoals;
    
    public function render()
    {
        $states = State::all();
        $setresidencials = Setresidencial::all();

        $goals = Goal::query()
                    ->when($this->nameGoals, function ($query){
                        $query->where('name',  'like', '%' .$this->nameGoals . '%');
                    })
                    ->when($this->stateGoals, function ($query) {
                        $query->where('state_id', $this->stateGoals);
                    })
                    ->when($this->setresidencialGoals, function ($query) {
                        $query->where('setresidencial_id', $this->setresidencialGoals);
                    })
                    ->get();

        return view('livewire.admin.goals.goals-filter',compact('states','goals','setresidencials'));
    }

    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameGoals':
                $this->nameGoals = null;
                break;
            case 'stateGoals':
                $this->stateGoals = null;
                break;
            case 'setresidencialGoals':
                $this->setresidencialGoals = null;
                break;
        }
    }


}
