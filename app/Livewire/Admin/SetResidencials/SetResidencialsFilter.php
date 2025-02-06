<?php

namespace App\Livewire\Admin\SetResidencials;

use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class SetResidencialsFilter extends Component
{
    use WithPagination;

    public $nameSetResidencial;
    public $nitSetResidencial;
    public $stateSetResidencial;
    public $userSetResidencial;

    public function render()
    {
        $states = State::all();
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [2])
                  ->whereNotIn('roles.id', [1,3]);
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
                $query->whereHas('users', function ($setQuery) {
                    $setQuery->where('user_id', $this->userSetResidencial);
                });
            })
        ->paginate(10);


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
