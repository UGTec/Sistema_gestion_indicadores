<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProcesoEstrategico;

class ProcesoEstrategicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procesos = [
            'Convenio Integra',
            'Soporte técnico',
            'Gestión Curricular',
            'FIEP',
            'SAC',
            'Inclusión',
            'Datos',
            'Gestión territorial',
            'Soporte Jurídico',
            'Normativa educacional',
            'Transparencia',
            'Auditoría',
            'Gestión comunicacional',
            'Género',
            'Certificación',
            'Coeficiente técnico'
        ];

        foreach ($procesos as $nombre) {
            ProcesoEstrategico::firstOrCreate(['nombre_proceso' => $nombre]);
        }
    }
}
