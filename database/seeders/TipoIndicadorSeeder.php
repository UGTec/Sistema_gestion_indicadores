<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoIndicadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_indicador')->insert([
            ['cod_tipo_indicador' => 1, 'tipo_indicador' => 'PMG', 'descripcion' => 'Programa de Mejoramiento de la Gestión'],
            ['cod_tipo_indicador' => 2, 'tipo_indicador' => 'CDC', 'descripcion' => 'Convenio de Desempeño Colectivo'],
            ['cod_tipo_indicador' => 3, 'tipo_indicador' => 'H', 'descripcion' => 'Indicadores de Desempeño'],
        ]);
    }
}
