<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perfil')->insert([
            ['cod_perfil' => 1, 'perfil' => 'Control de Gestión'],
            ['cod_perfil' => 2, 'perfil' => 'Jefatura de División'],
            ['cod_perfil' => 3, 'perfil' => 'Informante'],
            ['cod_perfil' => 4, 'perfil' => 'Revisor'],
            ['cod_perfil' => 5, 'perfil' => 'Observador'],
        ]);
    }
}
