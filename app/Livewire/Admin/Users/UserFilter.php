<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;

use App\Models\User;
use App\Models\State\State;
use Spatie\Permission\Models\Role;


class UserFilter extends Component
{

    public $nameUser;
    public $lastnameUser;
    public $emailUser;
    public $stateUser;
    public $roleUser;
    public $filtrosAvanzadosAbiertosUser = false;

    public function render()
    {
        $states = State::all();
        $roles = Role::all();
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
            ->get();

        return view('livewire.admin.users.user-filter',compact('states','roles','users'));
    }

    public function applyFilters()
    {
        $this->filtrosAvanzadosAbiertosUser = false; // O puedes guardar el estado actual, según tus necesidades
    }
    public function toggleAdvancedFilters()
    {
        $this->filtrosAvanzadosAbiertosUser = !$this->filtrosAvanzadosAbiertosUser;
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
        }
    }
}
