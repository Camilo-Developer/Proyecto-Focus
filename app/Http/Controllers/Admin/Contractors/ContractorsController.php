<?php

namespace App\Http\Controllers\Admin\Contractors;

use App\Http\Controllers\Controller;
use App\Models\Contractor\Contractor;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;

class ContractorsController extends Controller
{
    public function index()
    {
        
       $contractors = Contractor::paginate(5); 
       $states = State::all();
       $setresidencials = Setresidencial::all();
       return view('admin.contractors.index',compact('contractors','states','setresidencials'));
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request-> validate ([
            'name' => 'required',
            'phone' => 'required',
            'nit' => 'required',
            'address' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);
        $contractors = $request ->all();
        Contractor::create($contractors);
        return redirect()->route('admin.contractors.index')->with('success','El contrato fue creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contractor  $contractor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contractor  $contractor)
    {
        return view('admin.contractors.index',compact('contractor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contractor $contractor)
    {
        $request-> validaate ([
            'name' => 'required',
            'phone' => 'required',
            'nit' => 'required',
            'address' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);

        $data = $request->all();
        $contractor->update($data);
        return redirect()->route('admin.contractors.index')->with('edit','El contrato fue editado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contractor $contractor)
    {
        $contractor->delete();
        return redirect()->route('admin.agglomerations.index')->with('delete','El contrato fue eliminado correctamente.');
    }
}
