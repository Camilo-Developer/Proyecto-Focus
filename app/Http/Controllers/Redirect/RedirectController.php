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
        if (auth()->user()->can('admin.dashboard')){
            return redirect()->route('admin.dashboard');
        }elseif (auth()->user()->can('dashboard')){
            return redirect()->route('admin.dashboard');
        }else{
            Auth::logout();
            return redirect()->route('login')->with('info', 'No tiene los permisos requeridos para ingresar al sistema comuniquese con la mesa de ayuda.');
        }
    }
}
