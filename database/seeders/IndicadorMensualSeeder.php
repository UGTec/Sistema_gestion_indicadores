<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IndicadorMensual;

class IndicadorMensualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $registros = [
            [
                'cod_indicador' => 1,
                'numerador'     => 85,
                'denominador'   => 100,
                'mes'           => 1,
                'año'           => 2023,
                'resultado'     => 85,
                'cod_usuario'   => 1
            ],
            [
                'cod_indicador' => 1,
                'numerador'     => 92,
                'denominador'   => 100,
                'mes'           => 2,
                'año'           => 2023,
                'resultado'     => 92,
                'cod_usuario'   => 1
            ]
        ];

        foreach ($registros as $registro) {
            IndicadorMensual::create($registro);
        }
    }
}
