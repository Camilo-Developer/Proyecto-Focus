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
use Illuminate\Support\Facades\Auth;

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
        $units = Unit::where('state_id', 1)->get();
        $states = State::all();
        $agglomerations = Agglomeration::where('state_id', 1)->get();
        return view('admin.units.index',compact('units','states','agglomerations'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $agglomerations = Agglomeration::where('state_id', 1)->get();
            return view('admin.units.create',compact('states','agglomerations'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $setresidencial = Setresidencial::where('user_id',Auth::user()->id)->first();
            $states = State::all();
            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)->get();
            return view('admin.units.create',compact('states','agglomerations'));
        }
        
    }

    public function store(UnitsCreateRequest $request)
    {
        Unit::create($request->all());
        return redirect()->route('admin.units.index')->with('success','LA UNIDAD SE CREO CORRECTAMENTE.');
    }

    public function show(Unit $unit)
    {
        return view('admin.units.show',compact('unit'));

    }

    public function edit(Unit $unit)
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $agglomerations = Agglomeration::where('state_id', 1)->get();
            return view('admin.units.edit',compact('unit','states','agglomerations'));

        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $setresidencial = Setresidencial::where('user_id',Auth::user()->id)->first();
            $states = State::all();
            $agglomerations = Agglomeration::where('setresidencial_id', $setresidencial->id)->get();
            return view('admin.units.edit',compact('unit','states','agglomerations'));
        }
    }

    public function update(UnitsUpdateRequest $request, Unit $unit)
    {
        $unit->update($request->all());
        return redirect()->route('admin.units.index')->with('edit','LA UNIDAD SE EDITO CORRECTAMENTE.');

    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
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
