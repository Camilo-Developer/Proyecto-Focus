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
            'CLARO',
            'MOVISTAR',
            'TIGO',
            'BANCOLOMBIA',
            'GRUPO ÉXITO',
            'ALKOSTO',
            'COLPATRIA',
            'SURA',
            'ARGOS',
            'AVIANCA',
            'ECOPETROL',
            'NUTRESA',
            'POSTOBÓN',
            'CARVAJAL',
            'SERVIENTREGA',
            'RAPPI',
        ];

        foreach ($companies as $company) {
            Company::create([
                'name' => $company,
            ]);
        }
    }
}
