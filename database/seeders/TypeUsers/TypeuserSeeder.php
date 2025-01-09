<?php

namespace Database\Seeders\TypeUsers;

use App\Models\Typeuser\Typeuser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeusers = [
            'RESIDENTE',
            'VISITANTE',
            'CONTRATISTA',
        ];

        foreach ($typeusers as $typeuser) {
            Typeuser::create([
                'name' => $typeuser,
            ]);
        }
    }
}
