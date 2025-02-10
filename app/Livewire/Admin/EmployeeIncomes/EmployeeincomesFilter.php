<?php

namespace App\Livewire\Admin\EmployeeIncomes;

use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Visitor\Visitor;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeincomesFilter extends Component
{
    use WithPagination;

    public $dateInitEmployeeIncomes;
    public $dateFinishEmployeeIncomes;
    public $visitorsEmployeeIncomes;

    public function render()
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $employeeincomes = Employeeincome::query()
                ->when($this->dateInitEmployeeIncomes, function ($query){
                    $query->where('admission_date',  'like', '%' .$this->dateInitEmployeeIncomes . '%');
                })
                ->when($this->dateFinishEmployeeIncomes, function ($query){
                    $query->where('departure_date',  'like', '%' .$this->dateFinishEmployeeIncomes . '%');
                })
                ->when($this->visitorsEmployeeIncomes, function ($query) {
                    $query->where('visitor_id', $this->visitorsEmployeeIncomes);
                })
            ->paginate(10);

            $visitors = Visitor::all();

            return view('livewire.admin.employee-incomes.employeeincomes-filter',compact('employeeincomes','visitors'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $employeeincomes = Employeeincome::query()->where('setresidencial_id', $setresidencial->id)
                ->when($this->dateInitEmployeeIncomes, function ($query){
                    $query->where('admission_date',  'like', '%' .$this->dateInitEmployeeIncomes . '%');
                })
                ->when($this->dateFinishEmployeeIncomes, function ($query){
                    $query->where('departure_date',  'like', '%' .$this->dateFinishEmployeeIncomes . '%');
                })
                ->when($this->visitorsEmployeeIncomes, function ($query) {
                    $query->where('visitor_id', $this->visitorsEmployeeIncomes);
                })
            ->paginate(10);

            $visitors = Visitor::where('setresidencial_id', $setresidencial->id)->get();

            return view('livewire.admin.employee-incomes.employeeincomes-filter',compact('employeeincomes','visitors'));
        }
        elseif ( auth()->user()->hasRole('PORTERO')) {

            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $employeeincomes = Employeeincome::query()->where('setresidencial_id', $setresidencial->id)
                ->when($this->dateInitEmployeeIncomes, function ($query){
                    $query->where('admission_date',  'like', '%' .$this->dateInitEmployeeIncomes . '%');
                })
                ->when($this->dateFinishEmployeeIncomes, function ($query){
                    $query->where('departure_date',  'like', '%' .$this->dateFinishEmployeeIncomes . '%');
                })
                ->when($this->visitorsEmployeeIncomes, function ($query) {
                    $query->where('visitor_id', $this->visitorsEmployeeIncomes);
                })
            ->paginate(10);

            $visitors = Visitor::where('setresidencial_id', $setresidencial->id)->get();

            return view('livewire.admin.employee-incomes.employeeincomes-filter',compact('employeeincomes','visitors'));
        }
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
            case 'visitorsEmployeeIncomes':
                $this->visitorsEmployeeIncomes = null;
                break;
        }
    }
}
