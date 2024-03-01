<?php

namespace App\Http\Controllers\Admin\ElementEntries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ElementEntries\ElemententriesCreateRequest;
use App\Http\Requests\Admin\ElementEntries\ElemententriesUpdateRequest;
use App\Models\Element\Element;
use App\Models\ElementEntry\Elemententry;
use Illuminate\Http\Request;

class ElemententriesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.elemententries.index')->only('index');
        $this->middleware('can:admin.elemententries.edit')->only('edit', 'update');
        $this->middleware('can:admin.elemententries.create')->only('create', 'store');
        $this->middleware('can:admin.elemententries.destroy')->only('destroy');
    }

    public function index()
    {
        $elemententries = Elemententry::all();
        $elements = Element::all();
        return view('admin.elemententries.index',compact('elemententries','elements'));
    }


    public function create()
    {
        //
    }


    public function store(ElemententriesCreateRequest $request)
    {
        Elemententry::create($request->all());
        return redirect()->route('admin.elemententries.index')->with('success', 'El ingreso del elemento se a creado correctamente.');
    }

    public function show(Elemententry $elemententry)
    {
        return view('admin.elemententries.index',compact('elemententry'));
    }

    public function edit(Elemententry $elemententry)
    {
        return view('admin.elemententries.index',compact('elemententry'));
    }

    public function update(ElemententriesUpdateRequest $request, Elemententry $elemententry)
    {
        $elemententry->update($request->all());
        return redirect()->route('admin.elemententries.index')->with('success', 'El ingreso del elemento se a editado correctamente.');
    }

    public function destroy(Elemententry $elemententry)
    {
        $elemententry->delete();
        return redirect()->route('admin.elemententries.index')->with('delete','La eliminación del ingreso del elemento fue éxitosa');

    }
}
