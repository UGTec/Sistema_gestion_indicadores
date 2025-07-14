<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_usuario')->insert([
            ['cod_estado_usuario' => 1, 'estado_usuario' => 'Activo'],
            ['cod_estado_usuario' => 2, 'estado_usuario' => 'Inactivo'],
        ]);
    }
}
