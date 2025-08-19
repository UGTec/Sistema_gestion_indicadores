<?php

namespace Database\Seeders;

use App\Models\Indicador;
use Illuminate\Database\Seeder;

class IndicadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $indicadores = [
            [
                'cod_indicador'      => 1001,
                'indicador'          => 'Porcentaje de cumplimiento de metas',
                'objetivo'           => 'Medir el grado de cumplimiento de las metas establecidas',
                'cod_tipo_indicador' => 1,
                'cod_usuario'        => 1,
                'meta'               => 90
            ],
            [
                'cod_indicador'      => 1002,
                'indicador'          => 'Tasa de retención de estudiantes',
                'objetivo'           => 'Medir la capacidad de retener estudiantes durante el año académico',
                'cod_tipo_indicador' => 2,
                'cod_usuario'        => 2,
                'meta'               => 85
            ]
        ];

        foreach ($indicadores as $indicador) {
            Indicador::create($indicador);
        }
    }
}
