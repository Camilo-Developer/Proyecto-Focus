<?php

namespace App\Livewire\Admin\Goals;


use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Livewire\Component;
use Livewire\WithPagination;

class GoalsFilter extends Component
{
    
    use WithPagination;

    public $nameGoals;
    public $stateGoals;
    public $setresidencialGoals;
    
    public function render()
    {
        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $setresidencials = Setresidencial::get();

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
                        ->paginate(10);

            return view('livewire.admin.goals.goals-filter',compact('states','goals','setresidencials'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {
            $states = State::all();
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();

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
                ->whereHas('setresidencial', function ($query) use ($setresidencialIds) {
                    $query->whereIn('setresidencial_id', $setresidencialIds);
                })
                ->paginate(10);

            return view('livewire.admin.goals.goals-filter',compact('states','goals','setresidencials'));
        }
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
