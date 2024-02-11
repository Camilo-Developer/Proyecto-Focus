<?php

namespace App\Http\Controllers\Admin\Visitors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Visitors\VisitorsCreateRequest;
use App\Http\Requests\Admin\Visitors\VisitorsUpdateRequest;
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
 
    public function store(VisitorsCreateRequest $request)
    {
        Visitor::create($request-> all());
        return redirect()->route('admin.visitors.index')->with('success','El visitante se creo con éxito');
    }

    public function edit(Visitor $visitor)
    {
        return view('admin.visitors.index',compact('visitors'));
    }

    
    public function update(VisitorsUpdateRequest $request, Visitor $visitor)
    {
        $visitor->update($request->all());
        return redirect()->route('admin.visitors.index')->with('edit','El visitante se edito con éxito');

    }

    
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('admin.visitors.index')->with('delete','El visitante se elimin con éxito');
    }
}
