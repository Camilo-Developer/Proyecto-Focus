<?php

namespace App\Http\Controllers\Admin\ContratorEmployees;

use App\Http\Controllers\Controller;
use App\Models\Contractor\Contractor;
use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\State\State;



use Illuminate\Http\Request;

class ContratorEmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contractorsemployees = Contractoremployee::paginate(5); 
        $states = State::all();
        $contractors = Contractor::all();
        return view('admin.contratorsemployees.index',compact('contratorsemployees','states','setresidencials'));
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request-> validate ([
            'name' => 'required',
            'state_id' => 'required',
            'contractor_id' => 'required',
         ]);
         $contratorsemployees = $request ->all();
         Contractoremployee::create($contratorsemployees);
        return redirect()->route('admin.contractorsemployee.index')->with('success','El contrato del empleado fue creado correctamente.');
    


    }

    /**
     * Display the specified resource.
     */
    public function show(Contractoremployee $contractoremployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contractoremployee $contractoremployee)
    {
        return view('admin.contratorsemployees.index',compact('contractoremployee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contractoremployee $contractoremployee)
    {
        $request-> validaate ([
            'name' => 'required',
            'state_id' => 'required',
            'contractor_id' => 'required',
        ]);

        $data = $request->all();
        $contractoremployee->update($data);
        return redirect()->route('admin.contratorsemployees.index')->with('edit','El contrato del empleado fue editado correctamente.');
 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contractoremployee $contractoremployee)
    {
        //
    }
}
