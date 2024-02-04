<?php

namespace App\Http\Controllers\Admin\ContractorEmployees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContractorEmployees\ContractorEmployeesCreateRequest;
use App\Models\Contractor\Contractor;
use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ContractorEmployees\ContractorEmployeesUpdateRequest;
class ContractorEmployeesController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.contractoremployees.index')->only('index');
        $this->middleware('can:admin.contractoremployees.edit')->only('edit', 'update');
        $this->middleware('can:admin.contractoremployees.create')->only('create', 'store');
        $this->middleware('can:admin.contractoremployees.destroy')->only('destroy');
    }

    public function index()
    {
        $contractoremployees = Contractoremployee::all();
        $states = State::all();
        $contractors = Contractor::all();
        return view('admin.contractoremployees.index', compact('contractoremployees','states','contractors'));
    }

    public function create()
    {
        //
    }

    public function store(ContractorEmployeesCreateRequest $request)
    {
        Contractoremployee::create($request->all());
        return redirect()->route('admin.contractoremployees.index')->with('success','El empleado del contratista se creo correctamente.');

    }

    public function show(Contractoremployee $contractoremployee)
    {
        return view('admin.contractoremployees.index',compact('contractoremployee'));

    }

    public function edit(Contractoremployee $contractoremployee)
    {
        return view('admin.contractoremployees.index',compact('contractoremployee'));
    }

    public function update(ContractorEmployeesUpdateRequest $request, Contractoremployee $contractoremployee)
    {
        $contractoremployee->update($request->all());
        return redirect()->route('admin.contractoremployees.index')->with('success','El empleado del contratista se edito correctamente.');
    }

    public function destroy(Contractoremployee $contractoremployee)
    {
        $contractoremployee->delete();
        return redirect()->route('admin.contractoremployees.index')->with('success','El empleado del contratista se elimino correctamente.');
    }
}
