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
        $contractoremployees = Contractoremployee::all();
        return view('admin.elements.index',compact('elements','contractoremployees'));
    }

    public function store(ElementsCreateRequest $request)
    {
        Element::create($request->all());
        return redirect()->route('admin.elements.index')->with('success','El elemento se creo con éxito');
    }

    public function edit(Element $element)
    {
        return view('admin.elements.index',compact('element'));
    }


    public function update(ElementsUpdateRequest $request, Element $element)
    {
        $element->update($request->all());
        return redirect()->route('admin.elements.index')->with('edit','El elemento se edito con éxito');

    }


    public function destroy(Element $element)
    {
        $element->delete();
        return redirect()->route('admin.elements.index')->with('delete','El elemento se elimino con éxito');
    }
}
