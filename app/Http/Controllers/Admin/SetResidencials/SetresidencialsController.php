<?php

namespace App\Http\Controllers\Admin\SetResidencials;

use App\Http\Controllers\Controller;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use Illuminate\Http\Request;

class SetresidencialsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $setresidencials = Setresidencial::query()
            ->where('name', 'LIKE', "%$search%")
            ->paginate(5);
        $states = State::all();
        return view('admin.setresidencials.index',compact('setresidencials','states','search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'imagen' => 'required',
            'address' => 'required',
            'nit' => 'required',
            'state_id' => 'required',
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

        return redirect()->route('admin.setresidencials.index')->with('success','La creación del conjunto fue correcta.');

    }


    public function show(Setresidencial $setresidencial)
    {
        //
    }


    public function edit(Setresidencial $setresidencial)
    {
        return view('admin.setresidencials.index',compact('setresidencial'));
    }


    public function update(Request $request, Setresidencial $setresidencial)
    {
        $request->validate([
            'name' => 'required',
            'imagen' => 'nullable',
            'address' => 'required',
            'nit' => 'required',
            'state_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/setresidencials');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $data['imagen'] = 'setresidencials/' . $imagenImagen;

            if ($setresidencial->imagen) {
                $imagenAnterior = public_path('storage/' . $setresidencial->imagen);
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }
        } else {
            unset($data['imagen']);
        }

        $setresidencial->update($data);
        return redirect()->route('admin.setresidencials.index')->with('edit', 'El conjunto se edito correctamente.');

    }


    public function destroy(Setresidencial $setresidencial)
    {
        $setresidencial->delete();
        return redirect()->route('admin.setresidencials.index')->with('delete', 'El conjunto se elimino correctamente.');

    }
}
