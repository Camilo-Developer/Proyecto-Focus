<?php

namespace App\Http\Controllers\Admin\Visitors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visitors\VisitorsCreateRequest;
use App\Http\Requests\Admin\Visitors\VisitorsUpdateRequest;
use App\Models\Company\Company;
use App\Models\State\State;
use App\Models\Typeuser\Typeuser;
use App\Models\Visitor\Visitor;
use App\Models\VisitorEntry\Visitorentry;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    
    public function __construct(){
        $this->middleware('can:admin.visitors.index')->only('index');
        $this->middleware('can:admin.visitors.edit')->only('edit', 'update');
        $this->middleware('can:admin.visitors.create')->only('create', 'store');
        $this->middleware('can:admin.visitors.destroy')->only('destroy');
    }


    public function index()
    {
        $visitors = Visitor::all();
        return view('admin.visitors.index',compact('visitors'));
    }

    public function create()
    {
        $states = State::all();
        $typeusers = Typeuser::all();
        $companies = Company::all();
        return view('admin.visitors.create',compact('states','typeusers','companies'));
    }
 
    public function store(VisitorsCreateRequest $request)
    {
        $visitors = $request->all();


        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/visitors');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $visitors['imagen'] = 'visitors/' . $imagenImagen;
        }


        Visitor::create($visitors);

        return redirect()->route('admin.visitors.index')->with('success','EL VISITANTE SE CREO CORRECTAMENTE.');
    }
    public function show(Visitor $visitor)
    {
        return view('admin.visitors.show',compact('visitor'));
    }

    public function edit(Visitor $visitor)
    {
        $states = State::all();
        $typeusers = Typeuser::all();
        $companies = Company::all();
        return view('admin.visitors.edit',compact('visitor','states','typeusers','companies'));
    }
    
    public function update(VisitorsUpdateRequest $request, Visitor $visitor)
    {
        $data = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/visitors');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $data['imagen'] = 'visitors/' . $imagenImagen;
    
            // Eliminamos la imagen anterior si existe
            if ($visitor->imagen) {
                $imagenAnterior = public_path('storage/' . $visitor->imagen);
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }
        } else {
            unset($data['imagen']);
        }

        $visitor->update($data);
        return redirect()->route('admin.visitors.index')->with('edit','EL VISITANTE SE EDITO CORRECTAMENTE.');

    }

    
    public function destroy(Visitor $visitor)
    {
        try {
            // Eliminar la imagen si existe
            if ($visitor->imagen) {
                $imagenPath = public_path('storage/' . $visitor->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }

            $visitor->delete();
            return redirect()->route('admin.visitors.index')->with('delete', 'EL VISITANTE SE ELIMINÓ CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.visitors.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            return redirect()->route('admin.visitors.index')->with('info', 'OCURRIÓ UN ERROR AL INTENTAR ELIMINAR EL VISITANTE.');
        }
    }

}
