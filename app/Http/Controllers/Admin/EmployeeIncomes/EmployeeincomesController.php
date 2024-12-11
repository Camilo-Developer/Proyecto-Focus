<?php

namespace App\Http\Controllers\Admin\EmployeeIncomes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesCreateRequest;
use App\Http\Requests\Admin\EmployeeIncomes\EmployeeincomesUpdateRequest;
use App\Models\EmployeeIncome\Employeeincome;
use App\Models\Visitor\Visitor;
use Illuminate\Http\Request;

class EmployeeincomesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.employeeincomes.index')->only('index');
        $this->middleware('can:admin.employeeincomes.edit')->only('edit', 'update');
        $this->middleware('can:admin.employeeincomes.create')->only('create', 'store');
        $this->middleware('can:admin.employeeincomes.destroy')->only('destroy');
    }

    public function index()
    {
        $employeeincomes = Employeeincome::all();
        return view('admin.employeeincomes.index',compact('employeeincomes'));
    }

    public function create()
    {
        $visitors = Visitor::all();
        return view('admin.employeeincomes.create',compact('visitors'));
    }

    public function store(EmployeeincomesCreateRequest $request)
    {
        Employeeincome::create($request->all());
        return redirect()->route('admin.employeeincomes.index')->with('success','La creación del ingreso del empleado fue éxitosa');
    }

    public function show(Employeeincome $employeeincome)
    {
        return view('admin.employeeincomes.index',compact('employeeincome'));
    }

    public function edit(Employeeincome $employeeincome)
    {
        return view('admin.employeeincomes.index',compact('employeeincome'));
    }

    public function update(EmployeeincomesUpdateRequest $request, Employeeincome $employeeincome)
    {
        $employeeincome->update($request->all());
        return redirect()->route('admin.employeeincomes.index')->with('edit','La edición del ingreso del empleado fue éxitosa');
    }

    public function destroy(Employeeincome $employeeincome)
    {
        $employeeincome->delete();
        return redirect()->route('admin.employeeincomes.index')->with('delete','La eliminación del ingreso del empleado fue éxitosa');
    }
}
