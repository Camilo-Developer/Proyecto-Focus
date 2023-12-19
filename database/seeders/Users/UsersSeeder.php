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
            'name'=> 'Admin',
            'lastname'=> 'Admin',
            'type_document'=> 'CC',
            'document_number'=> '123456',
            'email'=> 'admin@gmail.com',
            'password'=> Hash::make('123'),
            'note'=> '',
            'state_id'=> '1',
        ])->assignRole('Admin');

        //
    }
}
