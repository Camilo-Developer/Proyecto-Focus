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

        //Permisos admin conjunto
        Permission::create([
            'name' => 'admin.setresidencials.index',
            'description'=> 'Lista de conjuntos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.create',
            'description'=> 'Creación del conjuntos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.edit',
            'description'=> 'Edición de conjuntos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.show',
            'description'=> 'Detalle del conjunto'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.setresidencials.destroy',
            'description'=> 'Eliminación del conjunto'
        ])->syncRoles([$role1]);


        //Permisos admin aglomeración
        Permission::create([
            'name' => 'admin.agglomerations.index',
            'description'=> 'Lista de aglomeraciones'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.agglomerations.create',
            'description'=> 'Creación de la aglomeración'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.agglomerations.edit',
            'description'=> 'Edición de la aglomeración'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.agglomerations.show',
            'description'=> 'Detalle de la aglomeración'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.agglomerations.destroy',
            'description'=> 'Eliminación de la aglomeración'
        ])->syncRoles([$role1]);

        //Permisos admin Contrators
        Permission::create([
            'name' => 'admin.contractors.index',
            'description'=> 'Lista de contratistas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractors.create',
            'description'=> 'Creación contratistas'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractors.edit',
            'description'=> 'Edición del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractors.show',
            'description'=> 'Detalle del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractors.destroy',
            'description'=> 'Eliminación del contratista'
        ])->syncRoles([$role1]);


        //Permisos admin Empleados del contratista
        Permission::create([
            'name' => 'admin.contractoremployees.index',
            'description'=> 'Lista de empleados del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractoremployees.create',
            'description'=> 'Creación de empleados del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractoremployees.edit',
            'description'=> 'Edición del empleado del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractoremployees.show',
            'description'=> 'Detalle del empleado del contratista'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.contractoremployees.destroy',
            'description'=> 'Eliminación del empleado del contratista'
        ])->syncRoles([$role1]);

        //Permisos admin Unidades
        Permission::create([
            'name' => 'admin.units.index',
            'description'=> 'Lista de Unidades'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.units.create',
            'description'=> 'Creación de Unidades'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.units.edit',
            'description'=> 'Edición de la unidad'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.units.show',
            'description'=> 'Detalle de la unidad'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.units.destroy',
            'description'=> 'Eliminación de la unidad'
        ])->syncRoles([$role1]);


        //Permisos admin Usuarios
        Permission::create([
            'name' => 'admin.users.index',
            'description'=> 'Lista de Usuarios'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.create',
            'description'=> 'Creación de Usuairios'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.edit',
            'description'=> 'Edición del Usuario'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.show',
            'description'=> 'Detalle del Usuario'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.users.destroy',
            'description'=> 'Eliminación del Usuario'
        ])->syncRoles([$role1]);



        //Permisos admin Elementos
        Permission::create([
            'name' => 'admin.elements.index',
            'description'=> 'Lista de Elementos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.elements.create',
            'description'=> 'Creación de Elementos'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.elements.edit',
            'description'=> 'Edición del Elemento'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.elements.show',
            'description'=> 'Detalle del Elemento'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.elements.destroy',
            'description'=> 'Eliminación del Elemento'
        ])->syncRoles([$role1]);


            //Permisos admin Goals
        Permission::create([
            'name' => 'admin.goals.index',
            'description'=> 'Lista de Goals'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.goals.create',
            'description'=> 'Creación de Goals'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.goals.edit',
            'description'=> 'Edición del Goal'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.goals.show',
            'description'=> 'Detalle del Goal'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.goals.destroy',
            'description'=> 'Eliminación del Goal'
        ])->syncRoles([$role1]);


             //Permisos admin Visitors
             Permission::create([
                'name' => 'admin.visitors.index',
                'description'=> 'Lista de Visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.visitors.create',
                'description'=> 'Creación de Visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.visitors.edit',
                'description'=> 'Edición del visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.visitors.show',
                'description'=> 'Detalle del visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.visitors.destroy',
                'description'=> 'Eliminación del visitante'
            ])->syncRoles([$role1]);




        //Permisos admin Turnos
        Permission::create([
            'name' => 'admin.shifts.index',
            'description'=> 'Lista de Turno'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.shifts.create',
            'description'=> 'Creación de Turno'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.shifts.edit',
            'description'=> 'Edición del Turno'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.shifts.show',
            'description'=> 'Detalle del Turno'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.shifts.destroy',
            'description'=> 'Eliminación del Turno'
        ])->syncRoles([$role1]);

        //Permisos admin Visitante
        Permission::create([
            'name' => 'admin.visitorentries.index',
            'description'=> 'Lista de Visitante'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.visitorentries.create',
            'description'=> 'Creación de Visitante'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.visitorentries.edit',
            'description'=> 'Edición del Visitante'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.visitorentries.show',
            'description'=> 'Detalle del Visitante'
        ])->syncRoles([$role1]);
        Permission::create([
            'name' => 'admin.visitorentries.destroy',
            'description'=> 'Eliminación del Visitante'
        ])->syncRoles([$role1]);

            
             //Permisos admin elemenentry
             Permission::create([
                'name' => 'admin.elementsentrys.index',
                'description'=> 'Lista de Visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.elementsentrys.create',
                'description'=> 'Creación de Visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.elementsentrys.edit',
                'description'=> 'Edición del visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.elementsentrys.show',
                'description'=> 'Detalle del visitante'
            ])->syncRoles([$role1]);
            Permission::create([
                'name' => 'admin.elementsentrys.destroy',
                'description'=> 'Eliminación del visitante'
            ])->syncRoles([$role1]);
    

    }
}
