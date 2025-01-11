<?php

namespace App\Http\Controllers\Admin\Units;

use App\Http\Controllers\Controller;
use App\Models\Agglomeration\Agglomeration;
use App\Models\State\State;
use App\Models\Unit\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Units\UnitsCreateRequest;
use App\Http\Requests\Admin\Units\UnitsUpdateRequest;
use App\Models\SetResidencial\Setresidencial;
use App\Models\Vehicle\Vehicle;
use App\Models\Visitor\Visitor;
use Illuminate\Support\Facades\Auth;

class UnitsController extends Controller
{

    public function __construct(){
        $this->middleware('can:admin.units.index')->only('index');
        $this->middleware('can:admin.units.edit')->only('edit', 'update');
        $this->middleware('can:admin.units.show')->only('show');
        $this->middleware('can:admin.units.create')->only('create', 'store');
        $this->middleware('can:admin.units.destroy')->only('destroy');
    }

    public function index()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $units = Unit::where('state_id', 1)->get();
        $states = State::all();
        $agglomerations = Agglomeration::where('state_id', 1)->get();
        return view('admin.units.index',compact('units','states','agglomerations'));
    }

    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $states = State::all();
            $agglomerations = Agglomeration::where('state_id', 1)->get();
            $visitors = Visitor::where('state_id',1)->get();
            $vehicles = Vehicle::where('state_id',1)->get();

            return view('admin.units.create',compact('states','agglomerations','visitors','vehicles'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();

            $states = State::all();
            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)->where('state_id', 1)->get();
            return view('admin.units.create',compact('states','agglomerations'));
        }
        
    }

    public function store(UnitsCreateRequest $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $unit = Unit::create($request->all());
        $unit->visitors()->sync($request->visitors);
        $unit->vehicles()->sync($request->vehicles);

        return redirect()->route('admin.units.index')->with('success','LA UNIDAD SE CREO CORRECTAMENTE.');
    }

    public function show(Unit $unit)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        return view('admin.units.show',compact('unit'));

    }

    public function edit(Unit $unit)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $agglomerations = Agglomeration::where('state_id', 1)
            ->orWhere(function ($query) use ($unit) {
                $query->where('state_id', 2)
                      ->whereHas('units', function ($q) use ($unit) {
                          $q->where('agglomeration_id', $unit->agglomeration_id);
                      });
            })
            ->get();

            $visitors = Visitor::where('state_id', 1)
                ->orWhere(function ($query) use ($unit) {
                    $query->where('state_id', 2)
                        ->whereHas('units', function ($q) use ($unit) {
                            $q->where('unit_id', $unit->id);
                        });
                })
            ->get();


            $vehicles = Vehicle::where('state_id', 1)
                ->orWhere(function ($query) use ($unit) {
                    $query->where('state_id', 2)
                        ->whereHas('units', function ($q) use ($unit) {
                            $q->where('unit_id', $unit->id);
                        });
                })
            ->get();

            $visitors_user = $unit->visitors->pluck('id')->toArray();
            $vehicles_user = $unit->vehicles->pluck('id')->toArray();


            return view('admin.units.edit',compact('unit','states','agglomerations','visitors','vehicles','visitors_user','vehicles_user'));

        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $setresidencial = auth()->user()->setresidencials()->where('state_id', 1)->first();
            $states = State::all();
            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)
                ->where('state_id', 1)
                ->orWhere(function ($query) use ($unit) {
                    $query->where('state_id', 2)
                          ->whereHas('units', function ($q) use ($unit) {
                              $q->where('agglomeration_id', $unit->agglomeration_id);
                          });
                })
            ->get();
            return view('admin.units.edit',compact('unit','states','agglomerations'));
        }
    }

    public function update(UnitsUpdateRequest $request, Unit $unit)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $unit->update($request->all());
        $unit->visitors()->sync($request->visitors);
        $unit->vehicles()->sync($request->vehicles);

        return redirect()->route('admin.units.index')->with('edit','LA UNIDAD SE EDITO CORRECTAMENTE.');

    }

    public function destroy(Unit $unit)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        
        try {
            $unit->delete();
            $unit->visitors()->detach();
            $unit->vehicles()->detach();

            return redirect()->route('admin.units.index')->with('delete','LA UNIDAD SE ELIMINO CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.units.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            // Otros errores
            return redirect()->route('admin.units.index')->with('info', 'OCURRIO UN ERROR AL INTENTAR ELIMINAR LA UNIDAD.');
        }
    }
}
