<?php

namespace App\Http\Controllers\Admin\Vehicles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vehicles\VehiclesCreateRequest;
use App\Http\Requests\Admin\Vehicles\VehiclesUpdateRequest;
use App\Models\State\State;
use App\Models\Vehicle\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.vehicles.index')->only('index');
        $this->middleware('can:admin.vehicles.edit')->only('edit', 'update');
        $this->middleware('can:admin.vehicles.create')->only('create', 'store');
        $this->middleware('can:admin.vehicles.destroy')->only('destroy');
    }

    public function index()
    {
        $states = State::all();
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index',compact('states','vehicles'));
    }

    public function create()
    {
        //
    }

    public function store(VehiclesCreateRequest $request)
    {
        Vehicle::create($request->all());
        return redirect()->route('admin.vehicles.index')->with('success','La creación del vehiculo fue éxitosa');
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.index',compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.index',compact('vehicle'));
    }

    public function update(VehiclesUpdateRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return redirect()->route('admin.vehicles.index')->with('success','La edición del vehiculo fue éxitosa');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success','La eliminación del vehiculo fue éxitosa');
    }
}
