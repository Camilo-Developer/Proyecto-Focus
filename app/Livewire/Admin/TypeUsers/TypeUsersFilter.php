<?php

namespace App\Livewire\Admin\TypeUsers;

use App\Models\Typeuser\Typeuser;
use Livewire\Component;

class TypeUsersFilter extends Component
{
    public $nameTypeusers;

    public function render()
    {
        $typeusers = Typeuser::query()
                    ->when($this->nameTypeusers, function ($query){
                        $query->where('name',  'like', '%' .$this->nameTypeusers . '%');
                    })
                ->get();
        return view('livewire.admin.type-users.type-users-filter',compact('typeusers'));
    }

    public function applyFilters()
    {
    }
   

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'nameTypeusers':
                $this->nameTypeusers = null;
                break;
        }
    }
}
