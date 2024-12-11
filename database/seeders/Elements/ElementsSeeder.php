<?php

namespace Database\Seeders\Elements;

use App\Models\Element\Element;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            // Carpintería
            ['name' => 'MARTILLO'],
            ['name' => 'SIERRA CIRCULAR'],
            ['name' => 'TALADRO ELÉCTRICO'],
            ['name' => 'LIJADORA'],
            ['name' => 'CINCEL'],
        
            // Jardinería
            ['name' => 'PALA'],
            ['name' => 'TIJERAS DE PODAR'],
            ['name' => 'RASTRILLO'],
            ['name' => 'REGADERA'],
            ['name' => 'MANGUERA'],
        
            // Mecánica
            ['name' => 'LLAVE INGLESA'],
            ['name' => 'DESTORNILLADOR DE ESTRELLA'],
            ['name' => 'JUEGO DE LLAVES ALLEN'],
            ['name' => 'GATO HIDRÁULICO'],
            ['name' => 'LLAVE DE TUBO'],
        
            // Oficina
            ['name' => 'COMPUTADORA'],
            ['name' => 'IMPRESORA MULTIFUNCIÓN'],
            ['name' => 'TELÉFONO FIJO'],
            ['name' => 'ESCRITORIO'],
            ['name' => 'SILLA ERGONÓMICA'],
        
            // Construcción
            ['name' => 'CASCO DE SEGURIDAD'],
            ['name' => 'GUANTES DE PROTECCIÓN'],
            ['name' => 'CINTA MÉTRICA'],
            ['name' => 'NIVEL'],
            ['name' => 'CARRETILLA'],
        
            // Electricidad
            ['name' => 'MULTÍMETRO'],
            ['name' => 'PINZAS DE ELECTRICISTA'],
            ['name' => 'CORTADOR DE CABLES'],
            ['name' => 'AISLANTE ELÉCTRICO'],
            ['name' => 'TESTER DE CORRIENTE'],
        
            // Limpieza
            ['name' => 'ESCOBA'],
            ['name' => 'TRAPEADOR'],
            ['name' => 'CUBETA'],
            ['name' => 'GUANTES DE GOMA'],
            ['name' => 'LIMPIAVIDRIOS'],
        
            // Otros
            ['name' => 'CAJA DE HERRAMIENTAS'],
            ['name' => 'LINTERNA'],
            ['name' => 'EXTINTOR'],
            ['name' => 'BOTIQUÍN DE PRIMEROS AUXILIOS'],
            ['name' => 'CERRADURA'],
        ];
        

        foreach ($tools as $tool) {
            Element::create($tool);
        }
    }
}
