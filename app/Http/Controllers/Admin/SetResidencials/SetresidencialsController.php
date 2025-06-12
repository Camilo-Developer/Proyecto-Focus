<?php

namespace App\Http\Controllers\Admin\SetResidencials;

use App\Http\Controllers\Controller;
use App\Models\SetResidencial\Setresidencial;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SetresidencialsController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.setresidencials.index')->only('index');
        $this->middleware('can:admin.setresidencials.create')->only('create', 'store');
        $this->middleware('can:admin.setresidencials.edit')->only('edit', 'update');
        $this->middleware('can:admin.setresidencials.show')->only('show');
        $this->middleware('can:admin.setresidencials.destroy')->only('destroy');
    }

    public function index(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $setresidencials = Setresidencial::all();
        $states = State::all();
        return view('admin.setresidencials.index',compact('setresidencials','states'));
    }

    public function create()
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $states = State::all();
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [2])
                  ->whereNotIn('roles.id', [1,3]);
        })
        ->where('state_id',1)
        ->whereDoesntHave('setresidencials')
        ->get();
        
        return view('admin.setresidencials.create',compact('states','users'));
    }

    public function store(Request $request)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $request->validate([
            'name' => 'required',
            'imagen' => 'required',
            'address' => 'required',
            'nit' => 'nullable|unique:setresidencials,nit',
            'state_id' => 'required',
            'users' => ['array', 'exists:users,id'],
        ], [
            'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
            'imagen.required' => 'EL CAMPO IMAGEN ES OBLIGATORIO.',
            'address.required' => 'EL CAMPO DIRECCIÓN ES OBLIGATORIO.',
            'nit.unique' => 'EL NIT YA HA SIDO REGISTRADO.', // Mensaje personalizado en español
            'state_id.required' => 'EL CAMPO ESTADO ES OBLIGATORIO.',
        ]);
        

        $alls = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/setresidencials');
            $imagenImagen = Str::random(20) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $alls['imagen'] = 'setresidencials/' . $imagenImagen;
        }

        $setresidencial = Setresidencial::create($alls);

        $setresidencial->users()->sync($request->users); 

        return redirect()->route('admin.setresidencials.index')->with('success','LA CREACIÓN DEL CONJUNTO FUE CORRECTA.');

    }


    public function show(Setresidencial $setresidencial)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        return view('admin.setresidencials.show',compact('setresidencial'));
    }


    public function edit(Setresidencial $setresidencial)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $states = State::all();

        $users = User::whereHas('roles', function ($query) {
                $query->whereIn('roles.id', [ 2]);
            })
            ->where(function($query) use ($setresidencial) {
                $query->where('state_id', 1)
                    ->whereDoesntHave('setresidencials', function ($query) use ($setresidencial) {
                        $query->where('setresidencial_id', '!=', $setresidencial->id);
                    });
            })
            ->orWhere(function ($query) use ($setresidencial) {
                $query->where('state_id', 2)
                    ->whereHas('setresidencials', function ($query) use ($setresidencial) {
                        $query->where('setresidencial_id', $setresidencial->id);
                    })
                    ->whereHas('roles', function ($query) {
                        $query->whereIn('roles.id', [2]);
                    });
            })
        ->get();

        $users_user = $setresidencial->users->pluck('id')->toArray();

        return view('admin.setresidencials.edit', compact('setresidencial', 'states', 'users', 'users_user'));
    }

    


    public function update(Request $request, Setresidencial $setresidencial)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }

        $request->validate([
            'name' => 'required',
            'imagen' => 'nullable',
            'address' => 'required',
            'nit' => 'nullable|unique:setresidencials,nit,' . $setresidencial->id,
            'state_id' => 'required',
            'users' => ['array', 'exists:users,id'],
        ], [
            'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
            'imagen.required' => 'EL CAMPO IMAGEN ES OBLIGATORIO.',
            'address.required' => 'EL CAMPO DIRECCIÓN ES OBLIGATORIO.',
            'nit.unique' => 'EL NIT YA HA SIDO REGISTRADO.',
            'state_id.required' => 'EL CAMPO ESTADO ES OBLIGATORIO.',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $rutaGuardarImagen = public_path('storage/setresidencials');
            $imagenImagen = Str::random(20) . '.' . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImagen, $imagenImagen);
            $data['imagen'] = 'setresidencials/' . $imagenImagen;

            if ($setresidencial->imagen) {
                $imagenAnterior = public_path('storage/' . $setresidencial->imagen);
                if (file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }
        } else {
            unset($data['imagen']);
        }

        $setresidencial->update($data);
        $setresidencial->users()->sync($request->users); 

        return redirect()->route('admin.setresidencials.index')->with('edit', 'EL CONJUNTO SE EDITO CORRECTAMENTE.');
    }



    public function destroy(Setresidencial $setresidencial)
    {
        if(auth()->user()->state_id == 2){
            Auth::logout();
            return redirect()->route('login')->with('info', 'EL USUARIO SE ENCUENTRA EN ESTADO INACTIVO EN EL SISTEMA POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
        }
        
        $authSetresidencials = auth()->user()->setresidencials()->where('state_id', 1)->first();

        if(auth()->user()->id !== 1 && auth()->user()->id !== 2){
            if(empty($authSetresidencials)){
                Auth::logout();
                return redirect()->route('login')->with('info', 'AÚN NO CUENTA CON UN CONJUNTO CREADO POR FAVOR CONTACTAR A UN ADMINISTRADOR.');
            }
        }
        
        try {
            if ($setresidencial->imagen) {
                $imagenPath = public_path('storage/' . $setresidencial->imagen);
                if (file_exists($imagenPath)) {
                    unlink($imagenPath);
                }
            }
            
            $setresidencial->users()->detach();  

            $setresidencial->delete();
            return redirect()->route('admin.setresidencials.index')->with('delete', 'EL CONJUNTO SE ELIMINO CORRECTAMENTE.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('admin.setresidencials.index')->with('info', 'NO SE PUDO ELIMINAR EL REGISTRO YA QUE ESTA ASOCIADO A OTROS REGISTROS.');
            }
            // Otros errores
            return redirect()->route('admin.setresidencials.index')->with('info', 'OCURRIO UN ERROR AL INTENTAR ELIMINAR EL CONJUNTO.');
        }

    }
}
