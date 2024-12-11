<?php

namespace App\Http\Controllers\Admin\Elements;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Elements\ElementsCreateRequest;
use App\Http\Requests\Admin\Elements\ElementsUpdateRequest;
use App\Models\ContractorEmployee\Contractoremployee;
use App\Models\Element\Element;
use Illuminate\Http\Request;

class ElementsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.elements.index')->only('index');
        $this->middleware('can:admin.elements.edit')->only('edit', 'update');
        $this->middleware('can:admin.elements.create')->only('create', 'store');
        $this->middleware('can:admin.elements.destroy')->only('destroy');
    }

    public function index()
    {
        $elements = Element::all();
        return view('admin.elements.index',compact('elements'));
    }
    public function create()
    {
        return view('admin.elements.create');
    }

    public function store(ElementsCreateRequest $request)
    {
        $elements = $request->all();


        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/elements');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $elements['imagen'] = 'elements/' . $imagenImagen;
        }

        Element::create($elements);
        return redirect()->route('admin.elements.index')->with('success','El elemento se creo con éxito');
    }
    
    public function show(Element $element)
    {
        return view('admin.elements.show',compact('element'));
    }

    public function edit(Element $element)
    {
        return view('admin.elements.edit',compact('element'));
    }


    public function update(ElementsUpdateRequest $request, Element $element)
    {
        $data = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/elements');
            $imagenImagen = date('YmdHis') . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $data['imagen'] = 'elements/' . $imagenImagen;
    
            // Eliminamos la imagen anterior si existe
            if ($element->imagen) {
                $imagenAnterior = public_path('storage/' . $element->imagen);
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }
        } else {
            unset($data['imagen']);
        }

        $element->update($data);
        return redirect()->route('admin.elements.index')->with('edit','El elemento se edito con éxito');

    }


    public function destroy(Element $element)
    {
        try {
            // Eliminar la imagen si existe
            if ($element->imagen) {
                $imagenPath = public_path('storage/' . $element->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            $element->delete();
            return redirect()->route('admin.elements.index')->with('delete','El elemento se elimino con éxito');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.elements.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTÁ ASOCIADO A OTROS REGISTROS.');
            }
            return redirect()->route('admin.elements.index')->with('info', 'OCURRIÓ UN ERROR AL INTENTAR ELIMINAR EL ELEMENTO.');
        }
    }
}
