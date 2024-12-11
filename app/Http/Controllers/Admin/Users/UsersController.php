<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Goal\Goal;
use Illuminate\Http\Request;
use App\Models\State\State;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Database\QueryException;
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
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $users = User::all();
        $states = State::all();
        $roles = Role::all();
        $goals = Goal::where('state_id', 1)->get();

        return view('admin.users.create', compact('users', 'states', 'roles','goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'type_document' => 'required',
            'document_number' => 'required',
            'email' => ['required', 'email', Rule::unique('users')], 
            'password' => 'required',
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
            'goals' => ['array', 'exists:goals,id'],
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

        return redirect()->route('admin.users.index')->with('success', 'EL USUARIO SE CREO CORRECTAMENTE.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $states = State::all();
        $roles = Role::all();
        $goals = Goal::where('state_id', 1)->get();
    
        // Obtener los IDs de las metas ya asignadas al usuario
        $goals_user = $user->goals->pluck('id')->toArray();
    
        return view('admin.users.edit', compact('user', 'states', 'roles', 'goals', 'goals_user'));
    }
    


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'nullable',
            'email' => ['required', 'email'],
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
            'goals' => ['array', 'exists:goals,id'], // Validar metas seleccionadas
        ]);

        $data = $request->all();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);
        $user->goals()->sync($request->goals); // Sincronizar metas

        return redirect()->route('admin.users.index')->with('edit', 'EL USUARIO SE EDITÓ CORRECTAMENTE.');
    }


    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('info', 'ESTE USUARIO NO SE PUEDE ELIMINAR YA QUE ES UNO DE LOS PRINCIPALES EN EL SISTEMA');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('delete', 'EL USUARIO SE ELIMINO CORRECTAMENTE.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('admin.users.index')->with('info', 'EL USUARIO NO SE PUEDE ELIMINAR YA QUE ESTA RELACIONADO CON OTRO REGISTRO.');
            }
        }
    }
}
