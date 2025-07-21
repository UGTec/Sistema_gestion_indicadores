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
            [
                'cod_division' => 1,
                'division'     => 'DIVISIÓN JURÍDICA',
                'created_at'   => now(),
                'updated_at'   => now()
            ],
            [
                'cod_division' => 2,
                'division'     => 'DIVISIÓN DE POLÍTICAS EDUCATIVAS',
                'created_at'   => now(),
                'updated_at'   => now()
            ],
            [
                'cod_division' => 3,
                'division'     => 'DIVISIÓN DE ADMINISTRACIÓN Y FINANZAS',
                'created_at'   => now(),
                'updated_at'   => now()
            ],
            [
                'cod_division' => 4,
                'division'     => 'GABINETE',
                'created_at'   => now(),
                'updated_at'   => now()
            ],
        ]);
    }
}
