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
        $role1 = Role::create(['name' => 'ADMINISTRADOR']);
        $role2 = Role::create(['name' => 'SUB_ADMINISTRADOR']);
        $role3 = Role::create(['name' => 'PORTERO']);


        //Permiso admin Dashboard
        Permission::create([
            'name' => 'admin.dashboard',
            'description'=> 'VER PANEL ADMINISTRATIVO ( ADMINISTRADOR )'
        ])->syncRoles([$role1,$role2,$role3]);

        //Permiso User Dashboard
        Permission::create([
            'name' => 'dashboard',
            'description'=> 'VER PANEL ADMINISTRATIVOS PORTEROS'
        ])->syncRoles([$role1, $role3]);

        
        //Permisos admin roles
        Permission::create([
            'name' => 'admin.roles.index',
            'description'=> 'LISTADO DE ROLES'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.create',
            'description'=> 'CREACIÓN DEL ROLES'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.edit',
            'description'=> 'EDICIÓN DEL ROL'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.show',
            'description'=> 'DETALLE DEL ROL'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.roles.destroy',
            'description'=> 'ELIMINACIÓN DEL ROL'
        ])->syncRoles([$role1]);

        //Permisos admin Estados
        // Permission::create([
        //     'name' => 'admin.states.index',
        //     'description'=> 'LISTADO DE ESTADOS '
        // ])->syncRoles([$role1]);
        // Permission::create([
        //     'name' => 'admin.states.create',
        //     'description'=> 'CREACIÓN DE ESTADOS'
        // ])->syncRoles([$role1]);
        // Permission::create([
        //     'name' => 'admin.states.edit',
        //     'description'=> 'EDICIÓN DE ESTADOS'
        // ])->syncRoles([$role1]);
        // Permission::create([
        //     'name' => 'admin.states.destroy',
        //     'description'=> 'ELIMINAR ESTADOS'
        // ])->syncRoles([$role1]);


        //Permisos admin Usuarios
        Permission::create([
            'name' => 'admin.users.index',
            'description'=> 'LISTADO DE USUARIOS'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.users.create',
            'description'=> 'CREACIÓN DE USUARIOS'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.users.edit',
            'description'=> 'EDICIÓN DEL USUARIO'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.users.show',
            'description'=> 'DETALLE DEL USUARIO'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.users.destroy',
            'description'=> 'ELIMINACIÓN DEL USUARIO'
        ])->syncRoles([$role1,$role2]);

        //Permisos admin conjunto
        Permission::create([
            'name' => 'admin.setresidencials.index',
            'description'=> 'LISTADO DE CONJUNTOS'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.create',
            'description'=> 'CREACIÓN DEL CONJUNTO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.edit',
            'description'=> 'EDICIÓN DEL CONJUNTO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.show',
            'description'=> 'DETALLE DEL CONJUNTO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.destroy',
            'description'=> 'ELIMINACIÓN DEL CONJUNTO'
        ])->syncRoles([$role1]);


         //Permisos admin aglomeración
         Permission::create([
            'name' => 'admin.agglomerations.index',
            'description'=> 'LISTADO DE AGLOMERACIONES'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.agglomerations.create',
            'description'=> 'CREACIÓN DE LA AGLOMERACIÓN'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.agglomerations.edit',
            'description'=> 'EDICIÓN DE LA AGLOMERACIÓN'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.agglomerations.show',
            'description'=> 'DETALLE DE LA AGLOMERACIÓN'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.agglomerations.destroy',
            'description'=> 'ELIMINACIÓN DE LA AGLOMERACIÓN'
        ])->syncRoles([$role1,$role2]);


         //Permisos admin Unidades
         Permission::create([
            'name' => 'admin.units.index',
            'description'=> 'LISTADO DE UNIDADES'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.units.create',
            'description'=> 'CREACIÓN DE UNIDADES'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.units.edit',
            'description'=> 'EDICIÓN DE LA UNIDAD'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.units.show',
            'description'=> 'DETALLE DE LA UNIDAD'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.units.destroy',
            'description'=> 'ELIMINACIÓN DE LA UNIDAD'
        ])->syncRoles([$role1,$role2]);


        //Permisos admin Goals
        Permission::create([
            'name' => 'admin.goals.index',
            'description'=> 'LISTADO DE PORTERIAS'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.goals.create',
            'description'=> 'CREACIÓN DE LA PORTERIA'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.goals.edit',
            'description'=> 'EDICIÓN DE LA PORTERIA'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.goals.show',
            'description'=> 'DETALLE DE LA PORTERIA'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.goals.destroy',
            'description'=> 'ELIMINACIÓN DE LA PORTERIA'
        ])->syncRoles([$role1,$role2]);


        //Permisos admin Visitors
        Permission::create([
            'name' => 'admin.visitors.index',
            'description'=> 'LISTADO DE VISITANTES'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.visitors.create',
            'description'=> 'CREACIÓN DEL VISITANTE'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.visitors.edit',
            'description'=> 'EDICIÓN DEL VISITANTE'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.visitors.show',
            'description'=> 'DETALLE DEL VISITANTE'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.visitors.destroy',
            'description'=> 'ELIMINACIÓN DEL VISITANTE'
        ])->syncRoles([$role1,$role2]);

        //Permisos admin TIPO DE USUARIOS
        Permission::create([
            'name' => 'admin.typeusers.index',
            'description'=> 'LISTADO DE TIPO DE USUARIOS'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.typeusers.create',
            'description'=> 'CREACIÓN DEL TIPO DE USUARIO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.typeusers.edit',
            'description'=> 'EDICIÓN DEL TIPO DE USUARIO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.typeusers.show',
            'description'=> 'DETALLE DEL TIPO DE USUARIO'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.typeusers.destroy',
            'description'=> 'ELIMINACIÓN DEL TIPO DE USUARIO'
        ])->syncRoles([$role1]);

         //Permisos admin compañia
         Permission::create([
            'name' => 'admin.companies.index',
            'description'=> 'LISTADO DE COMPAÑIA'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.companies.create',
            'description'=> 'CREACIÓN DEL COMPAÑIA'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.companies.edit',
            'description'=> 'EDICIÓN DEL COMPAÑIA'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.companies.show',
            'description'=> 'DETALLE DEL COMPAÑIA'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.companies.destroy',
            'description'=> 'ELIMINACIÓN DEL COMPAÑIA'
        ])->syncRoles([$role1]);


        //Permisos admin ELEMENTOS
        Permission::create([
            'name' => 'admin.elements.index',
            'description'=> 'LISTADO DE ELEMENTOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.elements.create',
            'description'=> 'CREACIÓN DEL ELEMENTOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.elements.edit',
            'description'=> 'EDICIÓN DEL ELEMENTOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.elements.show',
            'description'=> 'DETALLE DEL ELEMENTOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.elements.destroy',
            'description'=> 'ELIMINACIÓN DEL ELEMENTOS'
        ])->syncRoles([$role1]);

        //Permisos admin INGRESOS
        Permission::create([
            'name' => 'admin.employeeincomes.index',
            'description'=> 'LISTADO DE INGRESOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.employeeincomes.create',
            'description'=> 'CREACIÓN DEL INGRESOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.employeeincomes.edit',
            'description'=> 'EDICIÓN DEL INGRESOS'
        ])->syncRoles([$role1,$role2]);
        Permission::create([
            'name' => 'admin.employeeincomes.show',
            'description'=> 'DETALLE DEL INGRESOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.employeeincomes.destroy',
            'description'=> 'ELIMINACIÓN DEL INGRESOS'
        ])->syncRoles([$role1]);

        //Permisos admin VEHICULOS
        Permission::create([
            'name' => 'admin.vehicles.index',
            'description'=> 'LISTADO DE VEHICULOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.vehicles.create',
            'description'=> 'CREACIÓN DEL VEHICULOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.vehicles.edit',
            'description'=> 'EDICIÓN DEL VEHICULOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.vehicles.show',
            'description'=> 'DETALLE DEL VEHICULOS'
        ])->syncRoles([$role1,$role2,$role3]);
        Permission::create([
            'name' => 'admin.vehicles.destroy',
            'description'=> 'ELIMINACIÓN DEL VEHICULOS'
        ])->syncRoles([$role1,$role2]);


    }
}
