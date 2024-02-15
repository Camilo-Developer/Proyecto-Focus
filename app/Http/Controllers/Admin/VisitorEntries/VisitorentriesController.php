<?php

namespace App\Http\Controllers\Admin\VisitorEntries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VisitorEntries\VisitorentriesCreateRequest;
use App\Http\Requests\Admin\VisitorEntries\VisitorentriesUpdateRequest;
use App\Models\State\State;
use App\Models\Unit\Unit;
use App\Models\VisitorEntry\Visitorentry;
use Illuminate\Http\Request;

class VisitorentriesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.visitorentries.index')->only('index');
        $this->middleware('can:admin.visitorentries.edit')->only('edit', 'update');
        $this->middleware('can:admin.visitorentries.create')->only('create', 'store');
        $this->middleware('can:admin.visitorentries.destroy')->only('destroy');
    }

    public function index()
    {
        $visitorentries = Visitorentry::all();
        $units = Unit::all();
        $states = State::all();
        return view('admin.visitorentries.index',compact('visitorentries','units','states'));
    }


    public function create()
    {
        //
    }

    public function store(VisitorentriesCreateRequest $request)
    {
        Visitorentry::create($request->all());
        return redirect()->route('admin.visitorentries.index')->with('success','El ingreso del visitante fue creado con éxito');
    }

    public function show(Visitorentry $visitorentry)
    {
        //
    }

    public function edit(Visitorentry $visitorentry)
    {
        return view('admin.visitorentries.index',compact('visitorentry'));

    }

    public function update(VisitorentriesUpdateRequest $request, Visitorentry $visitorentry)
    {
        $visitorentry->update($request->all());
        return redirect()->route('admin.visitorentries.index')->with('edit','La edición del ingreso del visitante fue correcto');
    }

    public function destroy(Visitorentry $visitorentry)
    {
        $visitorentry->delete();
        return redirect()->route('admin.visitorentries.index')->with('delete','La eliminación del ingreso del visitante fue correcto');

    }
}
