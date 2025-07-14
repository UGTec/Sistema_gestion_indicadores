<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('division')->insert([
            ['cod_division' => 1, 'division' => 'DIVISIÓN JURÍDICA'],
            ['cod_division' => 2, 'division' => 'DIVISIÓN DE POLÍTICAS EDUCATIVAS'],
            ['cod_division' => 3, 'division' => 'DIVISIÓN DE ADMINISTRACIÓN Y FINANZAS'],
            ['cod_division' => 4, 'division' => 'GABINETE'],
        ]);
    }
}
