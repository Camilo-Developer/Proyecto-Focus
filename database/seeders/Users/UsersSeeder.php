<?php

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'FIDEL',
            'lastname'=> 'FOCUS',
            'type_document'=> 'CC',
            'document_number'=> '123456',
            'email'=> 'fidel@gmail.com',
            'password'=> Hash::make('123'),
            'state_id'=> '1',
        ])->assignRole('ADMINISTRADOR');

        User::create([
            'name'=> 'ALEJANDRO',
            'lastname'=> 'CORTES',
            'type_document'=> 'CC',
            'document_number'=> '123456',
            'email'=> 'alejandro@gmail.com',
            'password'=> Hash::make('123'),
            'state_id'=> '1',
        ])->assignRole('SUB_ADMINISTRADOR');

        User::create([
            'name'=> 'MILTON',
            'lastname'=> 'JIMENEZ',
            'type_document'=> 'CC',
            'document_number'=> '123456',
            'email'=> 'milton@gmail.com',
            'password'=> Hash::make('123'),
            'state_id'=> '1',
        ])->assignRole('PORTERO');

        //
    }
}
