<?php

namespace App\Http\Controllers\Admin\SetResidencials;

use App\Http\Controllers\Controller;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetresidencialsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.setresidencials.index')->only('index');
        $this->middleware('can:admin.setresidencials.create')->only('create', 'store');
        $this->middleware('can:admin.setresidencials.edit')->only('edit', 'update');
        $this->middleware('can:admin.setresidencials.show')->only('show');
        $this->middleware('can:admin.setresidencials.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $search = $request->input('search');

            $setresidencials = Setresidencial::query()
                ->where('name', 'LIKE', "%$search%")
                ->paginate(10);
            $states = State::all();
            return view('admin.setresidencials.index',compact('setresidencials','states','search'));
        }
        // elseif (auth()->user()->hasRole('SUB_ADMINISTRADOR')) {
        //     $search = $request->input('search');

        //     $setresidencials = Setresidencial::query()
        //         ->where('name', 'LIKE', "%$search%")
        //         ->where('user_id', Auth::user()->id)
        //         ->paginate(10);
        //     $states = State::all();
        //     return view('admin.setresidencials.index',compact('setresidencials','states','search'));
        // }
      
    }

    public function create()
    {
        $states = State::all();
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [1, 2])
                  ->whereNotIn('roles.id', [3]);
        })
        ->whereDoesntHave('setresidencials')
        ->get();
        
        return view('admin.setresidencials.create',compact('states','users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'imagen' => 'required',
            'address' => 'required',
            'nit' => 'nullable|unique:setresidencials,nit',
            'user_id' => 'nullable',
            'state_id' => 'required',
        ], [
            'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
            'imagen.required' => 'EL CAMPO IMAGEN ES OBLIGATORIO.',
            'address.required' => 'EL CAMPO DIRECCIÓN ES OBLIGATORIO.',
            'nit.unique' => 'EL NIT YA HA SIDO REGISTRADO.', // Mensaje personalizado en español
            'state_id.required' => 'EL CAMPO ESTADO ES OBLIGATORIO.',
        ]);
        

        $setresidencials = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/setresidencials');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $setresidencials['imagen'] = 'setresidencials/' . $imagenImagen;
        }
        Setresidencial::create($setresidencials);

        return redirect()->route('admin.setresidencials.index')->with('success','LA CREACIÓN DEL CONJUNTO FUE CORRECTA.');

    }


    public function show(Setresidencial $setresidencial)
    {
        return view('admin.setresidencials.show',compact('setresidencial'));
    }


    public function edit(Setresidencial $setresidencial)
    {
        $states = State::all();
        
        $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [1, 2])
                      ->whereNotIn('roles.id', [3]);
            })
            ->where(function ($query) use ($setresidencial) {
                $query->whereDoesntHave('setresidencials')
                      ->orWhere('id', $setresidencial->user_id);
            })
            ->get();
    
        return view('admin.setresidencials.edit', compact('setresidencial', 'states', 'users'));
    }
    


    public function update(Request $request, Setresidencial $setresidencial)
{
    $request->validate([
        'name' => 'required',
        'imagen' => 'nullable',
        'address' => 'required',
        // Modificamos la regla de validación para ignorar el NIT del registro actual
        'nit' => 'nullable|unique:setresidencials,nit,' . $setresidencial->id,
        'state_id' => 'required',
    ], [
        'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
        'imagen.required' => 'EL CAMPO IMAGEN ES OBLIGATORIO.',
        'address.required' => 'EL CAMPO DIRECCIÓN ES OBLIGATORIO.',
        'nit.unique' => 'EL NIT YA HA SIDO REGISTRADO.', // Mensaje personalizado en español
        'state_id.required' => 'EL CAMPO ESTADO ES OBLIGATORIO.',
    ]);

    $data = $request->all();

    if ($request->hasFile('imagen')){
        $imagen = $request->file('imagen');
        $rutaGuardarImagen = public_path('storage/setresidencials');
        $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
        $imagen->move($rutaGuardarImagen, $imagenImagen);
        $data['imagen'] = 'setresidencials/' . $imagenImagen;

        // Eliminamos la imagen anterior si existe
        if ($setresidencial->imagen) {
            $imagenAnterior = public_path('storage/' . $setresidencial->imagen);
            if (file_exists($imagenAnterior)) {
                unlink($imagenAnterior);
            }
        }
    } else {
        unset($data['imagen']);
    }

    // Actualizamos el registro con los datos validados
    $setresidencial->update($data);

    return redirect()->route('admin.setresidencials.index')->with('edit', 'EL CONJUNTO SE EDITO CORRECTAMENTE.');
}



    public function destroy(Setresidencial $setresidencial)
    {
        try {
            if ($setresidencial->imagen) {
                $imagenPath = public_path('storage/' . $setresidencial->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            $setresidencial->delete();
            return redirect()->route('admin.setresidencials.index')->with('delete', 'EL CONJUNTO SE ELIMINO CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.setresidencials.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTA ASOCIADO A OTROS REGISTROS.');
            }
            // Otros errores
            return redirect()->route('admin.setresidencials.index')->with('info', 'OCURRIO UN ERROR AL INTENTAR ELIMINAR EL CONJUNTO.');
        }

    }
}
