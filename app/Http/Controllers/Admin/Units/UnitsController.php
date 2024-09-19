<?php

namespace App\Http\Controllers\Admin\Units;

use App\Http\Controllers\Controller;
use App\Models\Agglomeration\Agglomeration;
use App\Models\State\State;
use App\Models\Unit\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Units\UnitsCreateRequest;
use App\Http\Requests\Admin\Units\UnitsUpdateRequest;
class UnitsController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.units.index')->only('index');
        $this->middleware('can:admin.units.edit')->only('edit', 'update');
        $this->middleware('can:admin.units.create')->only('create', 'store');
        $this->middleware('can:admin.units.destroy')->only('destroy');
    }

    public function index()
    {
        $units = Unit::all();
        $states = State::all();
        $agglomerations = Agglomeration::all();
        return view('admin.units.index',compact('units','states','agglomerations'));
    }

    public function create()
    {
        $states = State::all();
        $agglomerations = Agglomeration::all();
        return view('admin.units.create',compact('states','agglomerations'));
        
    }

    public function store(UnitsCreateRequest $request)
    {
        Unit::create($request->all());
        return redirect()->route('admin.units.index')->with('success','La unidad se creo correctamente.');
    }

    public function show(Unit $unit)
    {
        return view('admin.units.index',compact('unit'));

    }

    public function edit(Unit $unit)
    {
        return view('admin.units.index',compact('unit'));
    }

    public function update(UnitsUpdateRequest $request, Unit $unit)
    {
        $unit->update($request->all());
        return redirect()->route('admin.units.index')->with('edit','La unidad se edito correctamente.');

    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('delete','La unidad se elimino correctamente.');
    }
}
