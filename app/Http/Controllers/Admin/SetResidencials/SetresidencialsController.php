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
            'nit' => 'nullable|unique:setresidencials,nit',
            'state_id' => 'required',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'imagen.required' => 'El campo imagen es obligatorio.',
            'address.required' => 'El campo dirección es obligatorio.',
            'nit.unique' => 'El NIT ya ha sido registrado.', // Mensaje personalizado en español
            'state_id.required' => 'El campo estado es obligatorio.',
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
        // Modificamos la regla de validación para ignorar el NIT del registro actual
        'nit' => 'nullable|unique:setresidencials,nit,' . $setresidencial->id,
        'state_id' => 'required',
    ], [
        'name.required' => 'El campo nombre es obligatorio.',
        'imagen.nullable' => 'El campo imagen es obligatorio.',
        'address.required' => 'El campo dirección es obligatorio.',
        'nit.unique' => 'El NIT ya ha sido registrado.', // Mensaje personalizado en español
        'state_id.required' => 'El campo estado es obligatorio.',
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

    return redirect()->route('admin.setresidencials.index')->with('edit', 'El conjunto se editó correctamente.');
}



    public function destroy(Setresidencial $setresidencial)
    {
        $setresidencial->delete();
        return redirect()->route('admin.setresidencials.index')->with('delete', 'El conjunto se elimino correctamente.');

    }
}
