<?php

namespace Database\Seeders\Roles;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Portero']);


        //Permiso admin Dashboard
        Permission::create([
            'name' => 'admin.dashboard',
            'description'=> 'Ver panel administrativo ( Admin )'
        ])->syncRoles([$role1]);

        //Permiso User Dashboard
        Permission::create([
            'name' => 'dashboard',
            'description'=> 'Ver panel administrativo porteros'
        ])->syncRoles([$role1, $role2]);

        //Permisos admin Estados
        Permission::create([
            'name' => 'admin.states.index',
            'description'=> 'Lista de estados '
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.states.create',
            'description'=> 'Creación de estados'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.states.edit',
            'description'=> 'Edición de estados'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.states.destroy',
            'description'=> 'Eliminar estados'
        ])->syncRoles([$role1]);


        //Permisos admin roles
        Permission::create([
            'name' => 'admin.roles.index',
            'description'=> 'Listado de roles'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.create',
            'description'=> 'Creación del rol'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.edit',
            'description'=> 'Edición del rol'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.show',
            'description'=> 'Detalle del rol'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.destroy',
            'description'=> 'Eliminación del rol'
        ])->syncRoles([$role1]);


    }
}
