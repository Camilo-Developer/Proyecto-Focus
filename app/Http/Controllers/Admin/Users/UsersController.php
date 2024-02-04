<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
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
        $states = State::all();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'states', 'roles'));

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'type_document' => 'required',
            'document_number' => 'required',
            'note' => 'nullable',
            'email' => ['required', 'email', Rule::unique('users')], // Verifica unicidad del correo electrónico en la tabla 'users'
            'password' => 'required',
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
        ]);
        User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'type_document' => $request->type_document,
            'document_number' => $request->document_number,
            'note' => $request->note,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => $request->state_id,
        ])->roles()->sync($request->roles);
        return redirect()->route('admin.users.index')->with('success', 'El Usuario se ha creado correctamente.');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $states = State::all();
        $roles = Role::all();
        $roles_user = [];
        foreach ($user->roles as $role_user){
            array_push($roles_user, $role_user->id);
        }
        return view('admin.users.index', compact('user','states', 'roles','roles_user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'nullable',
            'email' => ['required', 'email'], // Verifica unicidad del correo electrónico en la tabla 'users'
            'state_id' => 'required',
            'roles' => ['required', 'array', 'min:1'],
        ]);
        $data = $request->all();

        // Verificar si se proporcionó una nueva contraseña
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Eliminar la clave "password" del array si no se proporcionó una nueva contraseña
            unset($data['password']);
        }

        $user->update($data);
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index')->with('edit', 'El Usuario se ha editado correctamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('info', 'Este usuario no se puede eliminar ya que es uno de los principales en el sistema');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('delete', 'El Usuario se ha eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('admin.users.index')->with('info', 'El Usuario no se puede eliminar, ya que está relacionado con otros registros.');
            }
        }
    }
}
