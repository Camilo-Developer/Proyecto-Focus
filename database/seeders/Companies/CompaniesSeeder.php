<?php

namespace Database\Seeders\Companies;

use App\Models\Company\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            'Claro',
            'Movistar',
            'Tigo',
            'Bancolombia',
            'Grupo Éxito',
            'Alkosto',
            'Colpatria',
            'Sura',
            'Argos',
            'Avianca',
            'Ecopetrol',
            'Nutresa',
            'Postobón',
            'Carvajal',
            'Servientrega',
            'Rappi',
        ];

        foreach ($companies as $company) {
            Company::create([
                'name' => $company,
            ]);
        }
    }
}
