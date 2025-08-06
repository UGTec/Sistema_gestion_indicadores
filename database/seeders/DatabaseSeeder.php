<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DivisionSeeder::class,
            EstadoUsuarioSeeder::class,
            TipoIndicadorSeeder::class,
            DepartamentoSeeder::class,
            UsuarioSeeder::class,
            IndicadorSeeder::class,
            IndicadorMensualSeeder::class,
            PermissionSeeder::class,
            IframeSeeder::class,
        ]);
    }
}
