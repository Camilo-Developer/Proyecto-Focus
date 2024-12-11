<?php

namespace App\Http\Controllers\Admin\States;

use App\Http\Controllers\Controller;
use App\Models\State\State;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;


class StatesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.states.index')->only('index');
        $this->middleware('can:admin.states.edit')->only('edit', 'update');
        $this->middleware('can:admin.states.create')->only('create', 'store');
        $this->middleware('can:admin.states.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $states = State::query()
            ->where('name', 'LIKE', "%$search%")
            ->paginate(5);
        return view('admin.states.index',compact('states','search'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.states.index')->with('info', 'ESTE ESTADO NO SE PUEDE CREAR CONSULTA AL ADMINISTRADOR.');

        $request->validate([
            'name' => 'required',
            'type_state' => 'required',
        ]);
        $states = $request->all();
        State::create($states);
        return redirect()->route('admin.states.index')->with('success', 'EL ESTADO SE CREO CORRECTAMENTE.');
    }


    public function edit(State $state)
    {
        return view('admin.states.index',compact('state'));

    }

    public function update(Request $request, State $state)
    {
        return redirect()->route('admin.states.index')->with('info', 'ESTE ESTADO NO SE PUEDE EDITAR CONSULTA A EL ADMINISTRADOR.');

        $request->validate([
            'name' => 'required',
            'type_state' => 'required',
        ]);
        $data = $request->all();
        $state->update($data);
        return redirect()->route('admin.states.index')->with('edit', 'EL ESTADO SE EDITO CORRECTAMENTE.');
    }

    public function destroy(State $state)
    {
        //if ($state->id <= 6) {
            return redirect()->route('admin.states.index')->with('info', 'ESTE ESTADO NO SE PUEDE ELIMINAR CONSULTA A EL ADMINSITRADOR.');
        //}

        try {
            $state->delete();
            return redirect()->route('admin.states.index')->with('delete', 'EL ESTADO SE HA ELIMINADO CORRECTAMENTE.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('admin.states.index')->with('info', 'EL ESTADO NO SE PUEDE ELIMINAR, YA QUE ESTA RELACIONADO CON OTROS REGISTROS.');
            }
        }
    }
}
