<?php

namespace App\Http\Controllers\Redirect;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function dashboard(){
        //dd(auth()->user()->getRoleNames()); // Retorna una colección de roles
        //dd(auth()->user()->getAllPermissions());
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


        if (auth()->user()->can('admin.dashboard')){
            return redirect()->route('admin.dashboard');
        }elseif (auth()->user()->can('dashboard')){
            return redirect()->route('admin.dashboard');
        }else{
            Auth::logout();
            return redirect()->route('login')->with('info', 'NO TIENE LOS PERMISOS REQUERIDOS PARA INGRESAR AL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
    }
}
