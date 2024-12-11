<?php

namespace App\Http\Controllers\Admin\Agglomerations;

use App\Http\Controllers\Controller;
use App\Models\Agglomeration\Agglomeration;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgglomerationsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.agglomerations.index')->only('index');
        $this->middleware('can:admin.agglomerations.create')->only('create', 'store');
        $this->middleware('can:admin.agglomerations.edit')->only('edit', 'update');
        $this->middleware('can:admin.agglomerations.show')->only('show');
        $this->middleware('can:admin.agglomerations.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {

            $search = $request->input('search');

            $agglomerations = Agglomeration::query()
                ->where('name', 'LIKE', "%$search%")
                ->paginate(10);
            $states = State::all();
            $setresidencials = Setresidencial::all();
            return view('admin.agglomerations.index',compact('agglomerations','states','search','setresidencials'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $search = $request->input('search');
            $setresidencial = Setresidencial::where('user_id',Auth::user()->id)->first();
            $agglomerations = Agglomeration::query()
                ->where('name', 'LIKE', "%$search%")
                ->where('setresidencial_id', $setresidencial->id)
                ->paginate(10);
            $states = State::all();
            $setresidencials = Setresidencial::all();
            return view('admin.agglomerations.index',compact('agglomerations','states','search','setresidencials'));
        }
    }
    public function create()
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $setresidencials = Setresidencial::where('state_id', 1)->get();
            return view('admin.agglomerations.create',compact('states','setresidencials'));

        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $states = State::all();
            $setresidencials = Setresidencial::where('user_id',Auth::user()->id)->get();
            return view('admin.agglomerations.create',compact('states','setresidencials'));
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type_agglomeration' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);
        $agglomerations = $request->all();
        Agglomeration::create($agglomerations);
        return redirect()->route('admin.agglomerations.index')->with('success','LA AGLOMERACIÓN DEL CONJUNTO FUE CREADA CORRECTAMENTE.');

    }

    public function show(Agglomeration $agglomeration)
    {
        return view('admin.agglomerations.show',compact('agglomeration'));
    }

    public function edit(Agglomeration $agglomeration)
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $states = State::all();
            $setresidencials = Setresidencial::where('state_id', 1)->get();
            return view('admin.agglomerations.edit',compact('agglomeration','states','setresidencials'));
        }elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
            $states = State::all();
            $setresidencials = Setresidencial::where('user_id',Auth::user()->id)->get();
            return view('admin.agglomerations.edit',compact('agglomeration','states','setresidencials'));
        }
    }

    public function update(Request $request, Agglomeration $agglomeration)
    {
        $request->validate([
            'name' => 'required',
            'type_agglomeration' => 'required',
            'state_id' => 'required',
            'setresidencial_id' => 'required',
        ]);
        $data = $request->all();
        $agglomeration->update($data);
        return redirect()->route('admin.agglomerations.index')->with('edit','LA AGLOMERACIÓN DEL CONJUNTO FUE EDITADA CORRECTAMENTE.');

    }

    public function destroy(Agglomeration $agglomeration)
    {
        try {
            $agglomeration->delete();
            return redirect()->route('admin.agglomerations.index')->with('delete','LA AGLOMERACIÓN DEL CONJUNTO FUE ELIMINADA CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.agglomerations.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            // Otros errores
            return redirect()->route('admin.agglomerations.index')->with('info', 'OCURRIO UN ERROR AL INTENTAR ELIMINAR LA AGLOMERACIÓN.');
        }
    }
}
