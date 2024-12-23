<?php

namespace App\Livewire\Admin\SetResidencials;

use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Livewire\Component;

class SetResidencialsFilter extends Component
{
    public $nameSetResidencial;
    public $nitSetResidencial;
    public $stateSetResidencial;
    public $userSetResidencial;

    public function render()
    {
        $states = State::all();
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [1, 2])
                  ->whereNotIn('roles.id', [3]);
        })
        ->get();

        $setresidencials = Setresidencial::query()
            ->when($this->nameSetResidencial, function ($query){
                $query->where('name',  'like', '%' .$this->nameSetResidencial . '%');
            })
            ->when($this->nitSetResidencial, function ($query){
                $query->where('nit',  'like', '%' .$this->nitSetResidencial . '%');
            })
            ->when($this->stateSetResidencial, function ($query) {
                $query->where('state_id', $this->stateSetResidencial);
            })
            ->when($this->userSetResidencial, function ($query) {
                $query->where('user_id', $this->userSetResidencial);
            })
        ->get();


        return view('livewire.admin.set-residencials.set-residencials-filter',compact('states', 'users', 'setresidencials'));
    }

    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameSetResidencial':
                $this->nameSetResidencial = null;
                break;
            case 'nitSetResidencial':
                $this->nitSetResidencial = null;
                break;
            case 'stateSetResidencial':
                $this->stateSetResidencial = null;
                break;
            case 'userSetResidencial':
                $this->userSetResidencial = null;
                break;
        }
    }
}
