<?php

namespace App\Exports\Admin\EmployeeIncomesExport;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use App\Models\EmployeeIncome\Employeeincome;
class EmployeeIncomesExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate ." 00:00:00";
        $this->endDate = $endDate ." 23:59:59";
    }

    public function view(): View
    {
        if (auth()->user()->can('admin.permission.administrator')) {

            // Filtrar los ingresos según el rango de fechas

            // $employeeIncomes = Employeeincome::with(['visitor', 'elements'])
            // ->whereBetween('admission_date', [$this->startDate, $this->endDate])
            // ->orWhere(function ($query) {
            //     $query->whereNull('departure_date')
            //         ->whereBetween('admission_date', [$this->startDate, $this->endDate]);
            // })
            // ->get();

            $employeeIncomes = Employeeincome::with(['visitor', 'elements', 'exitentries','vehicles', 'visitors'])
                ->whereBetween('admission_date', [$this->startDate, $this->endDate])
            ->get();



            return view('exports.employee_incomes', [
                'employeeIncomes' => $employeeIncomes,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ]);
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $employeeIncomes = Employeeincome::with(['visitor', 'elements'])
            ->where('setresidencial_id', $setresidencial->id) // 🔹 Filtro correcto por conjunto residencial
            ->whereBetween('admission_date', [$this->startDate, $this->endDate])
            ->get();
        


            return view('exports.employee_incomes', [
                'employeeIncomes' => $employeeIncomes,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
            ]);
        }
    }
}