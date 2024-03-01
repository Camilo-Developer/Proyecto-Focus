<?php

namespace App\Livewire\Admin\EmployeeIncomes;

use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\EmployeeIncome\Employeeincome;
use Livewire\Component;

class EmployeeincomesFilter extends Component
{
    public $dateInitEmployeeIncomes;
    public $dateFinishEmployeeIncomes;
    public $contractoremployeeEmployeeIncomes;

    public function render()
    {
        $contractoremployees = Contractoremployee::all();
        $employeeincomes = Employeeincome::query()
            ->when($this->dateInitEmployeeIncomes, function ($query){
                $query->where('admission_date',  'like', '%' .$this->dateInitEmployeeIncomes . '%');
            })
            ->when($this->dateFinishEmployeeIncomes, function ($query){
                $query->where('departure_date',  'like', '%' .$this->dateFinishEmployeeIncomes . '%');
            })
            ->when($this->contractoremployeeEmployeeIncomes, function ($query) {
                $query->where('contractoremployee_id', $this->contractoremployeeEmployeeIncomes);
            })
            ->get();

        return view('livewire.admin.employee-incomes.employeeincomes-filter',compact('contractoremployees','employeeincomes'));
    }

    public function applyFilters()
    {
    }

    public function removeFilter($filter)
    {
        switch ($filter) {
            case 'dateInitEmployeeIncomes':
                $this->dateInitEmployeeIncomes = null;
                break;
            case 'dateFinishEmployeeIncomes':
                $this->dateFinishEmployeeIncomes = null;
                break;
            case 'contractoremployeeEmployeeIncomes':
                $this->contractoremployeeEmployeeIncomes = null;
                break;
        }
    }
}
