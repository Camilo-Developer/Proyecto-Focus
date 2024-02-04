<?php

namespace App\Livewire\Admin\ContractorEmployees;

use Livewire\Component;
use App\Models\State\State;
use App\Models\Contractor\Contractor;
use App\Models\ContractorEmployee\Contractoremployee;

class ContractorEmployeesFilter extends Component
{
    public $nameEmployee;
    public $stateEmployee;
    public $contractorEmployee;
    public $filtrosAvanzadosAbiertos = false;


    public function render()
    {
        $states = State::all();
        $contractors = Contractor::all();
        $contractoremployees = Contractoremployee::query()
            ->when($this->nameEmployee, function ($query){
                $query->where('name',  'like', '%' .$this->nameEmployee . '%');
            })
            ->when($this->stateEmployee, function ($query) {
                $query->where('state_id', $this->stateEmployee);
            })
            ->when($this->contractorEmployee, function ($query) {
                $query->where('contractor_id', $this->contractorEmployee);
            })
            ->get();

        return view('livewire.admin.contractor-employees.contractor-employees-filter', compact('states','contractors','contractoremployees'));
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
            case 'nameEmployee':
                $this->nameEmployee = null;
                break;
            case 'stateEmployee':
                $this->stateEmployee = null;
                break;
            case 'contractorEmployee':
                $this->contractorEmployee = null;
                break;
        }
    }
}
