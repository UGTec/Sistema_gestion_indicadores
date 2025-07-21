<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamento')->insert([
            [
                'cod_departamento' => 5,
                'departamento'     => 'Departamento de Supervisión',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 2,
                'departamento'     => 'Departamento de Presupuesto y Gestión Financiera',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 3,
                'departamento'     => 'Departamento de Gestión y Desarrollo de Personas',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 4,
                'departamento'     => 'Unidad de Administración Interna',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 6,
                'departamento'     => 'Unidad de Planificación Estratégica y Control de Gestión',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 7,
                'departamento'     => 'Departamento de Gestión Curricular',
                'cod_division'     => 2,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 8,
                'departamento'     => 'Departamento de Educación Integral',
                'cod_division'     => 2,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 9,
                'departamento'     => 'Departamento de Estudios y Estadística',
                'cod_division'     => 2,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 10,
                'departamento'     => 'Unidad de Gestión Territorial',
                'cod_division'     => 2,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 11,
                'departamento'     => 'Unidad de Auditoría Interna',
                'cod_division'     => 4,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 12,
                'departamento'     => 'Unidad de Comunicaciones',
                'cod_division'     => 4,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 13,
                'departamento'     => 'Gabinete',
                'cod_division'     => 4,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 14,
                'departamento'     => 'Departamento de Procedimientos Jurídicos',
                'cod_division'     => 1,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 15,
                'departamento'     => 'Departamento Normativo',
                'cod_division'     => 1,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 16,
                'departamento'     => 'Departamento de Cobertura y Certificaciones',
                'cod_division'     => 1,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 17,
                'departamento'     => 'Unidad de transparencia, lobby y solicitudes de Presidencia',
                'cod_division'     => 1,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
            [
                'cod_departamento' => 1,
                'departamento'     => 'Unidad de Gestión Tecnológica',
                'cod_division'     => 3,
                'created_at'       => now(),
                'updated_at'       => now()
            ],
        ]);
    }
}
