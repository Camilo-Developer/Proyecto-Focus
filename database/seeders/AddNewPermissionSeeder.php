<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddNewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = 'ADMINISTRADOR';
        $role2 = 'SUB_ADMINISTRADOR';
        $role3 = 'PORTERO';


        Permission::create([
            'name' => 'admin.permission.administrator',
            'description'=> 'PERMISOS PARA UN PERSONAL CON ROL ( ADMINISTRADOR )'
        ])->syncRoles([$role1]);

        Permission::create([
            'name' => 'admin.permission.subadministrator',
            'description'=> 'PERMISOS PARA UN PERSONAL CON ROL ( SUB ADMINISTRADOR )'
        ])->syncRoles([$role2]);

        Permission::create([
            'name' => 'admin.permission.goalie',
            'description'=> 'PERMISOS PARA UN PERSONAL CON ROL ( PORTERO )'
        ])->syncRoles([$role3]);
    }
}
