<?php

namespace App\Http\Controllers\Admin\TypeUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeUsers\TypeUsersCreateRequest;
use App\Models\Typeuser\Typeuser;
use Illuminate\Http\Request;

class TypeUsersController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.typeusers.index')->only('index');
        $this->middleware('can:admin.typeusers.create')->only('create', 'store');
        $this->middleware('can:admin.typeusers.edit')->only('edit', 'update');
        $this->middleware('can:admin.typeusers.show')->only('show');
        $this->middleware('can:admin.typeusers.destroy')->only('destroy');
    }
 
    public function index()
    {
        $typeusers = Typeuser::all();
        return view('admin.typeusers.index',compact('typeusers'));
    }


    public function create()
    {
        return view('admin.typeusers.create');
    }

    public function store(TypeUsersCreateRequest $request)
    {
        Typeuser::create($request->all());
        return redirect()->route('admin.typeusers.index')->with('success','EL TIPO DE USUARIO FUE CREADO CORRECTAMENTE.');
    }


    public function show(Typeuser $typeuser)
    {
        return view('admin.typeusers.show',compact('typeuser'));
    }


    public function edit(Typeuser $typeuser)
    {
        return view('admin.typeusers.edit',compact('typeuser'));
    }


    public function update(TypeUsersCreateRequest $request, Typeuser $typeuser)
    {
        $typeuser->update($request->all());
        return redirect()->route('admin.typeusers.index')->with('edit','EL TIPO DE USUARIO FUE EDITADO CORRECTAMENTE.');
    }


    public function destroy(Typeuser $typeuser)
    {
        $typeuser->delete();
        return redirect()->route('admin.typeusers.index')->with('delete','EL TIPO DE USUARIO FUE ELIMINADO CORRECTAMENTE.');
    }
}
