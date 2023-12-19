<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\QueryException;

class RolesController extends Controller
{
    public function __construct(){
        $this->middleware('can:admin.roles.index')->only('index');
        $this->middleware('can:admin.roles.edit')->only('edit', 'update');
        $this->middleware('can:admin.roles.show')->only('show');
        $this->middleware('can:admin.roles.create')->only('create', 'store');
        $this->middleware('can:admin.roles.destroy')->only('destroy');
    }


    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.index', $role)->with('info', 'El rol se creo con exito');
    }


    public function show(Role $role)
    {
        $permissions = Permission::all();
        $permisosa = [];
        foreach($role->permissions as $role_permission){
            array_push($permisosa, $role_permission->pivot->permission_id);
        }
        return view('admin.roles.show',compact('role', 'permissions'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $permisos = [];
        foreach($role->permissions as $role_permission){
            array_push($permisos, $role_permission->pivot->permission_id);
        }
        return view('admin.roles.edit',compact('role', 'permissions','permisos'));

    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.index')->with('edit', 'El rol se edito correctamente.');
    }

    public function destroy(Role $role)
    {
        if ($role->id <= 4) {
            return redirect()->route('admin.roles.index')->with('info', 'Este rol no se puede eliminar ya que es uno de los principales en el sistema');
        }

        try {
            $role->delete();
            return redirect()->route('admin.roles.index')->with('delete', 'El rol se elimino correctamente.');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('admin.roles.index')->with('info', 'El rol no se puede eliminar, ya que está relacionado con otros registros.');
            }
        }

    }

}
