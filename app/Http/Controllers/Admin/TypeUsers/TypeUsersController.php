<?php

namespace App\Http\Controllers\Admin\TypeUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeUsers\TypeUsersCreateRequest;
use App\Models\Typeuser\Typeuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $typeusers = Typeuser::all();
        return view('admin.typeusers.index',compact('typeusers'));
    }


    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        return view('admin.typeusers.create');
    }

    public function store(TypeUsersCreateRequest $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        Typeuser::create($request->all());
        return redirect()->route('admin.typeusers.index')->with('success','EL TIPO DE USUARIO FUE CREADO CORRECTAMENTE.');
    }


    public function show(Typeuser $typeuser)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        return view('admin.typeusers.show',compact('typeuser'));
    }


    public function edit(Typeuser $typeuser)
    {
        return view('admin.typeusers.edit',compact('typeuser'));
    }


    public function update(TypeUsersCreateRequest $request, Typeuser $typeuser)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $typeuser->update($request->all());
        return redirect()->route('admin.typeusers.index')->with('edit','EL TIPO DE USUARIO FUE EDITADO CORRECTAMENTE.');
    }


    public function destroy(Typeuser $typeuser)
    {
        if (auth()->user()->state_id == 2) {
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }

        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if (auth()->user()->id !== 1) {
            if (empty($authSetresidencials)) {
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $relatedVisitorsCount = $typeuser->visitors()->count();
        if ($relatedVisitorsCount > 0) {
            return redirect()->route('admin.typeusers.index')->with('info', 'NO SE PUEDE ELIMINAR ESTE TIPO DE USUARIO PORQUE TIENE REGISTROS ASOCIADOS.');
        }

        $typeuser->delete();
        return redirect()->route('admin.typeusers.index')->with('delete', 'EL TIPO DE USUARIO FUE ELIMINADO CORRECTAMENTE.');
    }

}
