<?php

namespace App\Http\Controllers\Admin\ElementEntrys;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ElementEntrys\ElementEntryCreateRequest;
use App\Http\Requests\Admin\ElementEntrys\ElementEntryUpdateRequest;
use App\Models\Element\Element;
use App\Models\ElementEntry\Elemententry;
use Illuminate\Http\Request;

class ElementEntryController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.elemententrys.index')->only('index');
        $this->middleware('can:admin.elemententrys.edit')->only('edit', 'update');
        $this->middleware('can:admin.elemententrys.create')->only('create', 'store');
        $this->middleware('can:admin.elemententrys.destroy')->only('destroy');
    }


    public function index()
    {
        $elementsentrys = Elemententry::all();
        $elements = Element::all();
        return view('admin.elementsentrys.index',compact('elementsentrys','elements'));
    }

    public function store(ElementEntryCreateRequest $request)
    {
        Elemententry::create($request->all());
        return redirect()->route('admin.elementsentrys.index')->with('success','El ingreso se creó con éxito');
    }

    public function edit(Elemententry $elementsentrys)
    {
        return view('admin.elementsentrys.index',compact('element'));
    }

    public function update(ElementEntryUpdateRequest $request, Elemententry $elementsentrys)
    {
        $elementsentrys->update($request->all());
        return redirect()->route('admin.elementsentrys.index')->with('edit','El ingreso del elemento se edito con éxito');
    }

    public function destroy(Elemententry $elementsentrys)
    {
        $elementsentrys->delete();
        return redirect()->route('admin.elementsentrys.index')->with('delete','El elemento se elimino con éxito');
    
    }
}
