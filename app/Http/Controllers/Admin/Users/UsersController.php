<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Goal\Goal;
use App\Models\SetResidencial\Setresidencial;
use Illuminate\Http\Request;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only('edit', 'update');
        $this->middleware('can:admin.users.show')->only('show');
        $this->middleware('can:admin.users.create')->only('create', 'store');
        $this->middleware('can:admin.users.destroy')->only('destroy');
    }
    public function index()
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

        if (auth()->user()->can('admin.permission.administrator')) {
            $users = User::whereNotIn('id', [1, 2])->get();
            return view('admin.users.index', compact('users'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {

            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();
            $users = User::whereNotIn('id', [1, 2])->whereHas('setresidencials', function ($query) use ($setresidencialIds) {
                $query->whereIn('setresidencial_id', $setresidencialIds);
            })
            ->whereHas('setresidencials') // Aseguramos que los usuarios tengan al menos un conjunto residencial
            ->get();

            return view('admin.users.index', compact('users'));
        }
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

        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $roles = Role::all();
            $goals = Goal::where('state_id', 1)->get();
            $setresidencials = Setresidencial::where('state_id', 1)->get();
            return view('admin.users.create', compact( 'states', 'roles','goals','setresidencials'));
        }elseif (auth()->user()->can('admin.permission.subadministrator')) {
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();
            $states = State::all();
            $roles = Role::where('id','!=', 1)->get();
            $goals = Goal::whereIn('setresidencial_id', $setresidencialIds)->where('state_id', 1)->get();
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            return view('admin.users.create', compact( 'states', 'roles','goals','setresidencials'));
        }
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

        $documentNumber = $request->document_number;
        $setresidencialIds = $request->setresidencials;

        if (is_array($setresidencialIds) && count($setresidencialIds) > 0) {
            $existe = \DB::table('setresidencials_has_users')
                ->join('users', 'setresidencials_has_users.user_id', '=', 'users.id')
                ->whereIn('setresidencials_has_users.setresidencial_id', $setresidencialIds)
                ->where('users.document_number', $documentNumber)
            ->exists();

            if ($existe) {
                return back()->withErrors([
                    'document_number' => 'EL NÚMERO DE DOCUMENTO YA SE ENCUENTRA REGISTRADO EN EL SISTEMA.'
                ])->withInput();
            }
        }


       $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'type_document' => 'nullable',
            'document_number' => 'nullable',
            'email' => ['required', 'email', Rule::unique('users')], 
            'password' => 'required',
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
            'goals' => ['array', 'exists:goals,id'],
            'setresidencials' => ['array', 'exists:setresidencials,id'],
        ], [
            'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
            'lastname.required' => 'EL CAMPO APELLIDO ES OBLIGATORIO.',
            'type_document.nullable' => 'EL TIPO DE DOCUMENTO ES OBLIGATORIO.',
            'document_number.nullable' => 'EL NÚMERO DE DOCUMENTO ES OBLIGATORIO.',
            'email.required' => 'EL CORREO ELECTRÓNICO ES OBLIGATORIO.',
            'email.email' => 'EL FORMATO DEL CORREO ELECTRÓNICO NO ES VÁLIDO.',
            'email.unique' => 'EL CORREO ELECTRÓNICO YA ESTÁ EN USO.',
            'password.required' => 'LA CONTRASEÑA ES OBLIGATORIA.',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO.',
            'roles.required' => 'EL CAMPO ROL ES OBLIGATORIO.',
            'roles.array' => 'EL CAMPO ROL DEBE SER UNA LISTA.',
            'roles.min' => 'DEBE SELECCIONAR AL MENOS UN ROL.',
            'goals.array' => 'EL CAMPO METAS DEBE SER UNA LISTA.',
            'goals.exists' => 'ALGUNA DE LAS METAS SELECCIONADAS NO EXISTE.',
            'setresidencials.array' => 'EL CAMPO CONJUNTOS DEBE SER UNA LISTA.',
            'setresidencials.exists' => 'ALGUNO DE LOS CONJUNTOS SELECCIONADOS NO EXISTE.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'type_document' => $request->type_document,
            'document_number' => $request->document_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => $request->state_id,
        ]);
    
        $user->roles()->sync($request->roles);
        $user->goals()->sync($request->goals); 
        $user->setresidencials()->sync($request->setresidencials); 

        return redirect()->route('admin.users.index')->with('success', 'EL USUARIO SE CREO CORRECTAMENTE.');
    }

    public function show(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('info', 'NO TIENE LOS PERMISOS PARA VER EL DETALLE DE ESTE USUARIO.');
        }

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

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {

        // Evitar que intenten acceder al usuario con ID 1
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('info', 'NO TIENE LOS PERMISOS PARA EDITAR ESTE USUARIO.');
        }
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
    
        if (auth()->user()->can('admin.permission.administrator')) {
            $states = State::all();
            $roles = Role::all();
            
            $goals = Goal::where('state_id', 1)
                ->orWhere(function ($query) use ($user) {
                    $query->where('state_id', 2)
                          ->whereHas('users', function ($q) use ($user) {
                              $q->where('user_id', $user->id);
                          });
                })
                ->get();
    
            $setresidencials = Setresidencial::where('state_id', 1)
                ->orWhere(function ($query) use ($user) {
                    $query->where('state_id', 2)
                        ->whereHas('users', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        });
                })
            ->get();
            $goals_user = $user->goals->pluck('id')->toArray();
            $setresidencials_user = $user->setresidencials->pluck('id')->toArray();
        
            return view('admin.users.edit', compact('user', 'states', 'roles', 'goals', 'setresidencials', 'goals_user', 'setresidencials_user'));
        } elseif (auth()->user()->can('admin.permission.subadministrator')) {
            $setresidencialIds = auth()->user()->setresidencials->pluck('id')->toArray();
        
            $states = State::all();
            $roles = Role::where('id','!=', 1)->get();
            
            $goals = Goal::whereIn('setresidencial_id', $setresidencialIds)
                ->where('state_id', 1)
                ->orWhere(function ($query) use ($user) {
                    $query->where('state_id', 2)
                          ->whereHas('users', function ($q) use ($user) {
                              $q->where('user_id', $user->id);
                          });
                })
                ->get();
    
            $setresidencials = auth()->user()->setresidencials()->where('state_id', 1)->get();
            $goals_user = $user->goals->pluck('id')->toArray();
            $setresidencials_user = $user->setresidencials->pluck('id')->toArray();
        
            return view('admin.users.edit', compact('user', 'states', 'roles', 'goals', 'setresidencials', 'goals_user', 'setresidencials_user'));
        }
    }
    
    


    public function update(Request $request, User $user)
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

        $documentNumber = $request->document_number;
        $setresidencialIds = $request->setresidencials;

        if (is_array($setresidencialIds) && count($setresidencialIds) > 0) {
            $existe = \DB::table('setresidencials_has_users')
                ->join('users', 'setresidencials_has_users.user_id', '=', 'users.id')
                ->whereIn('setresidencials_has_users.setresidencial_id', $setresidencialIds)
                ->where('users.document_number', $documentNumber)
                ->where('users.id', '!=', $user->id) 
                ->exists();

            if ($existe) {
                return back()->withErrors([
                    'document_number' => 'EL NÚMERO DE DOCUMENTO YA SE ENCUENTRA REGISTRADO EN EL SISTEMA.'
                ])->withInput();
            }
        }

        $request->validate([
            'name' => 'required',
            'lastname' => 'nullable',
            'type_document' => 'nullable',
            'document_number' => 'nullable',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable',
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
            'goals' => ['array', 'exists:goals,id'],
            'setresidencials' => ['array', 'exists:setresidencials,id'],
        ], [
            'name.required' => 'EL CAMPO NOMBRE ES OBLIGATORIO.',
            'lastname.required' => 'EL CAMPO APELLIDO ES OBLIGATORIO.',
            'type_document.nullable' => 'EL TIPO DE DOCUMENTO ES OBLIGATORIO.',
            'document_number.nullable' => 'EL NÚMERO DE DOCUMENTO ES OBLIGATORIO.',
            'email.required' => 'EL CORREO ELECTRÓNICO ES OBLIGATORIO.',
            'email.email' => 'EL FORMATO DEL CORREO ELECTRÓNICO NO ES VÁLIDO.',
            'email.unique' => 'EL CORREO ELECTRÓNICO YA ESTÁ EN USO.',
            'state_id.required' => 'EL ESTADO ES OBLIGATORIO.',
            'password.required' => 'LA CONTRASEÑA ES OBLIGATORIA.',
            'roles.required' => 'EL CAMPO ROL ES OBLIGATORIO.',
            'roles.array' => 'EL CAMPO ROL DEBE SER UNA LISTA.',
            'roles.min' => 'DEBE SELECCIONAR AL MENOS UN ROL.',
            'goals.array' => 'EL CAMPO METAS DEBE SER UNA LISTA.',
            'goals.exists' => 'ALGUNA DE LAS METAS SELECCIONADAS NO EXISTE.',
            'setresidencials.array' => 'EL CAMPO CONJUNTOS DEBE SER UNA LISTA.',
            'setresidencials.exists' => 'ALGUNO DE LOS CONJUNTOS SELECCIONADOS NO EXISTE.',
        ]);

        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);
        $user->goals()->sync($request->goals); 
        $user->setresidencials()->sync($request->setresidencials); 

        return redirect()->route('admin.users.index')->with('edit', 'EL USUARIO SE EDITÓ CORRECTAMENTE.');
    }


    public function destroy(User $user)
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

        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('info', 'ESTE USUARIO NO SE PUEDE ELIMINAR YA QUE ES UNO DE LOS PRINCIPALES EN EL SISTEMA');
        }

        if (auth()->id() === $user->id) {
                return redirect()->route('admin.users.index')->with('info', 'NO PUEDE ELIMINAR SU PROPIO USUARIO.');
            }
            
        try {
             if ($user->roles()->exists() || $user->goals()->exists() || $user->setresidencials()->exists()) {
                return redirect()->route('admin.users.index')->with('info', 'EL USUARIO NO SE PUEDE ELIMINAR YA QUE TIENE INGRESOS O SALIDAS REGISTRADAS.');
            }
            
            $user->roles()->detach();
            $user->goals()->detach();
            $user->setresidencials()->detach();  

            $user->delete();
            return redirect()->route('admin.users.index')->with('delete', 'EL USUARIO SE ELIMINO CORRECTAMENTE.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('admin.users.index')->with('info', 'EL USUARIO NO SE PUEDE ELIMINAR YA QUE ESTA RELACIONADO CON OTRO REGISTRO.');
            }
            return redirect()->route('admin.users.index')->with('info', 'OCURRIÓ UN ERROR AL INTENTAR ELIMINAR EL USUARIO.');
        }
    }
}
