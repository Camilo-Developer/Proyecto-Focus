<?php

namespace Database\Seeders\States;

use App\Models\State\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create([
            'name' => 'ACTIVO',
            'type_state' => '1',
        ]);

        State::create([
            'name' => 'DESACTIVO',
            'type_state' => '2',
        ]);
    }
}
