<?php

namespace App\Livewire\Admin\Users;

use App\Models\SetResidencial\Setresidencial;
use Livewire\Component;

use App\Models\User;
use App\Models\State\State;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;


class UserFilter extends Component
{

    use WithPagination;

    public $nameUser;
    public $lastnameUser;
    public $emailUser;
    public $stateUser;
    public $roleUser;
    public $setResidencialUser;
    public $filtrosAvanzadosAbiertos = false;

    public function render()
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $roles = Role::all();
            $setresidencials = Setresidencial::get();
            $users = User::query()
                ->when($this->nameUser, function ($query){
                    $query->where('name',  'like', '%' .$this->nameUser . '%');
                })
                ->when($this->lastnameUser, function ($query){
                    $query->where('lastname',  'like', '%' .$this->lastnameUser . '%');
                })
                ->when($this->emailUser, function ($query){
                    $query->where('email',  'like', '%' .$this->emailUser . '%');
                })
                ->when($this->stateUser, function ($query) {
                    $query->where('state_id', $this->stateUser);
                })
                ->when($this->roleUser, function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('id', $this->roleUser);
                    });
                })
                ->when($this->setResidencialUser, function ($query) {
                    $query->whereHas('setresidencials', function ($setQuery) {
                        $setQuery->where('setresidencial_id', $this->setResidencialUser);
                    });
                })
            ->paginate(10);
                
            return view('livewire.admin.users.user-filter',compact('states','roles','setresidencials','users'));

        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $states = State::all();
            $roles = Role::all();
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();

            $users = User::query()
                ->when($this->nameUser, function ($query){
                    $query->where('name',  'like', '%' .$this->nameUser . '%');
                })
                ->when($this->lastnameUser, function ($query){
                    $query->where('lastname',  'like', '%' .$this->lastnameUser . '%');
                })
                ->when($this->emailUser, function ($query){
                    $query->where('email',  'like', '%' .$this->emailUser . '%');
                })
                ->when($this->stateUser, function ($query) {
                    $query->where('state_id', $this->stateUser);
                })
                ->when($this->roleUser, function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('id', $this->roleUser);
                    });
                })
                ->when($this->setResidencialUser, function ($query) {
                    $query->whereHas('setresidencials', function ($setQuery) {
                        $setQuery->where('setresidencial_id', $this->setResidencialUser);
                    });
                })
                ->whereHas('setresidencials', function ($query) use ($setresidencialIds) {
                    $query->whereIn('setresidencial_id', $setresidencialIds);
                })
                ->whereHas('setresidencials') 
            ->paginate(10);
                
            return view('livewire.admin.users.user-filter',compact('states','roles','setresidencials','users'));
        }

    }

    public function applyFilters()
    {
        $this->filtrosAvanzadosAbiertos = false; // O puedes guardar el estado actual, según tus necesidades
    }

    public function toggleAdvancedFilters()
    {
        $this->filtrosAvanzadosAbiertos = !$this->filtrosAvanzadosAbiertos;
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameUser':
                $this->nameUser = null;
                break;
            case 'lastnameUser':
                $this->lastnameUser = null;
                break;
            case 'emailUser':
                $this->emailUser = null;
                break;
            case 'stateUser':
                $this->stateUser = null;
                break;
            case 'roleUser':
                $this->roleUser = null;
                break;
                case 'setResidencialUser':
                    $this->setResidencialUser = null;
                    break;
        }
    }
}
