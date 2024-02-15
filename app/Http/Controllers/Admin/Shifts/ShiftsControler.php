<?php

namespace App\Http\Controllers\Admin\Shifts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shifts\ShiftsCreateRequest;
use App\Http\Requests\Admin\Shifts\ShiftsUpdateRequest;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Shifts\Shifts;
use App\Models\State\State;
use Illuminate\Http\Request;

class ShiftsControler extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.shifts.index')->only('index');
        $this->middleware('can:admin.shifts.edit')->only('edit', 'update');
        $this->middleware('can:admin.shifts.create')->only('create', 'store');
        $this->middleware('can:admin.shifts.destroy')->only('destroy');
    }

    public function index()
    {
        $shifts = Shifts::all();
        $states = State::all();
        $setresidencials =Setresidencial::all();
        return view('admin.shifts.index',compact('shifts','states','setresidencials'));
    }

    public function create()
    {
        //
    }

    public function store(ShiftsCreateRequest $request)
    {
        Shifts::create($request->all());
        return redirect()->route('admin.shifts.index')->with('success','El turno se creo correctamente');
    }

    public function show(Shifts $shift)
    {
        return view('admin.shifts.index',compact('shift'));

    }

    public function edit(Shifts $shift)
    {
        return view('admin.shifts.index',compact('shift'));
    }

    public function update(ShiftsUpdateRequest $request, Shifts $shift)
    {
        $shift->update($request->all());
        return redirect()->route('admin.shifts.index')->with('edit','El turno se edito correctamente');
    }

    public function destroy(Shifts $shift)
    {
        $shift->delete();
        return redirect()->route('admin.shifts.index')->with('edit','El turno se edito correctamente');
    }
}
