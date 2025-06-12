<?php

namespace App\Http\Controllers\Admin\Vehicles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Vehicles\VehiclesCreateRequest;
use App\Http\Requests\Admin\Vehicles\VehiclesUpdateRequest;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\Unit\Unit;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VehiclesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.vehicles.index')->only('index');
        $this->middleware('can:admin.vehicles.edit')->only('edit', 'update');
        $this->middleware('can:admin.vehicles.create')->only('create', 'store');
        $this->middleware('can:admin.vehicles.show')->only('show');
        $this->middleware('can:admin.vehicles.destroy')->only('destroy');
    }

    public function index()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $states = State::all();
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index',compact('states','vehicles'));
    }

    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $states = State::all();
            $units = Unit::where('state_id',1)->get();
            $visitors = Visitor::where('state_id',1)->get();
            $setresidencials = Setresidencial::where('state_id',1)->get();

            return view('admin.vehicles.create',compact('states','units','visitors','setresidencials'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR') || auth()->user()->hasRole('PORTERO')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $states = State::all();
            $units = Unit::where('state_id',1)->whereHas('agglomeration', function ($query) use ($setresidencial) {
                $query->where('setresidencial_id', $setresidencial->id);
            })->get();
            $visitors = Visitor::where('setresidencial_id', $setresidencial->id)->where('state_id',1)->get();
            return view('admin.vehicles.create',compact('states','units','visitors','setresidencial'));
        }
    }

    public function store(VehiclesCreateRequest $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        $data = $request->all();

        if ($request->has('imagen')) {
            $base64Image = $request->input('imagen');
            $image = str_replace('data:image/png;base64,', '', $base64Image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'vehicles/' . Str::random(20) . '.png';
            \File::put(public_path('storage/' . $imageName), base64_decode($image));
            $data['imagen'] = $imageName;
        }

        $vehicle = Vehicle::create($data);

        $vehicle->units()->sync($request->units);
        $vehicle->visitors()->sync($request->visitors);

        return redirect()->route('admin.vehicles.index')->with('success','La creación del vehiculo fue éxitosa');
    }

    public function show(Vehicle $vehicle)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        return view('admin.vehicles.show',compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $states = State::all();
            $units = Unit::where('state_id', 1)
                ->orWhere(function ($query) use ($vehicle) {
                    $query->where('state_id', 2)
                        ->whereHas('vehicles', function ($q) use ($vehicle) {
                            $q->where('vehicle_id', $vehicle->id);
                        });
                })
            ->get();

            $visitors = Visitor::where('state_id', 1)
                ->orWhere(function ($query) use ($vehicle) {
                    $query->where('state_id', 2)
                        ->whereHas('vehicles', function ($q) use ($vehicle) {
                            $q->where('vehicle_id', $vehicle->id);
                        });
                })
            ->get();

            $units_vehicles = $vehicle->units->pluck('id')->toArray();
            $visitors_vehicles = $vehicle->visitors->pluck('id')->toArray();

            $setresidencials = Setresidencial::where('state_id', 1)
            ->orWhere(function ($query) use ($vehicle) {
                $query->where('state_id', 2)
                      ->whereHas('vehicles', function ($q) use ($vehicle) {
                          $q->where('setresidencial_id', $vehicle->setresidencial_id);
                      });
            })->get();

            return view('admin.vehicles.edit',compact('vehicle','states','units','visitors','units_vehicles','visitors_vehicles','setresidencials'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR') || auth()->user()->hasRole('PORTERO')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();


            $states = State::all();
            $units = Unit::where('state_id', 1)->whereHas('agglomeration', function ($query) use ($setresidencial) {
                $query->where('setresidencial_id', $setresidencial->id);
                 })
                ->orWhere(function ($query) use ($vehicle) {
                    $query->where('state_id', 2)
                        ->whereHas('vehicles', function ($q) use ($vehicle) {
                            $q->where('vehicle_id', $vehicle->id);
                        });
                })
            ->get();

            $visitors = Visitor::where('state_id', 1)->where('setresidencial_id', $setresidencial->id)
                ->orWhere(function ($query) use ($vehicle) {
                    $query->where('state_id', 2)
                        ->whereHas('vehicles', function ($q) use ($vehicle) {
                            $q->where('vehicle_id', $vehicle->id);
                        });
                })
            ->get();

            $units_vehicles = $vehicle->units->pluck('id')->toArray();
            $visitors_vehicles = $vehicle->visitors->pluck('id')->toArray();


            return view('admin.vehicles.edit',compact('vehicle','states','units','visitors','units_vehicles','visitors_vehicles','setresidencial'));
        }
    }

    public function update(VehiclesUpdateRequest $request, Vehicle $vehicle)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $data = $request->all();

        if ($request->has('imagen') && $request->input('imagen')) {
            $base64Image = $request->input('imagen');

            if (strpos($base64Image, 'data:image/') === 0) {
                [$type, $image] = explode(';', $base64Image);
                [, $image] = explode(',', $image);

                $extension = str_contains($type, 'image/png') ? 'png' : 'jpeg';

                $imageName = 'visitors/' . Str::random(20) . '.' . $extension;

                \File::put(public_path('storage/' . $imageName), base64_decode($image));
                $data['imagen'] = $imageName;

                if ($vehicle->imagen && file_exists(public_path('storage/' . $vehicle->imagen))) {
                    unlink(public_path('storage/' . $vehicle->imagen));
                }
            } elseif (strpos($base64Image, 'vehicles/') === 0) {
                $data['imagen'] = $base64Image;
            } 
        } else {
            $data['imagen'] = $vehicle->imagen; 
        }

        $vehicle->update($data);
        $vehicle->units()->sync($request->units);
        $vehicle->visitors()->sync($request->visitors);

        return redirect()->route('admin.vehicles.index')->with('success','La edición del vehiculo fue éxitosa');
    }

    public function destroy(Vehicle $vehicle)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        
        if ($vehicle->units()->exists()) {
            return redirect()->route('admin.vehicles.index')->with('info', 'NO SE PUEDE ELIMINAR EL VEHÍCULO PORQUE TIENE REGISTROS ASOCIADOS.');
        }

        if ($vehicle->visitors()->exists()) {
            return redirect()->route('admin.vehicles.index')->with('info', 'NO SE PUEDE ELIMINAR EL VEHÍCULO PORQUE TIENE REGISTROS ASOCIADOS.');
        }

        $vehicle->delete();
        $vehicle->units()->detach();
        $vehicle->visitors()->detach();

        return redirect()->route('admin.vehicles.index')->with('success', 'LA ELIMINACIÓN DEL VEHÍCULO FUE EXITOSA.');
    }
}
