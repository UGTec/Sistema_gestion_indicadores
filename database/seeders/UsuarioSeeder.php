<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            [
                'usuario'            => 'nicolas.borgoño',
                'nombre'             => 'Nicolás',
                'primer_apellido'    => 'Borgoño',
                'segundo_apellido'   => 'Becerra',
                'correo_electronico' => 'nicolas.borgoño@mineduc.cl',
                'cod_perfil'         => 3,
                'cod_departamento'   => 5,
                'cod_usuario'        => 1,
                'cod_estado_usuario' => 1,
                'password'           => Hash::make('123456789'),
            ],
            [
                'usuario'            => 'ariel.torrealba',
                'nombre'             => 'Ariel',
                'primer_apellido'    => 'Torrealba',
                'segundo_apellido'   => 'Orellana',
                'correo_electronico' => 'ariel.torrealba@mineduc.cl',
                'cod_perfil'         => 3,
                'cod_departamento'   => 2,
                'cod_usuario'        => 2,
                'cod_estado_usuario' => 1,
                'password'           => Hash::make('123456789'),
            ],
            // ... (todos los demás usuarios del archivo SQL)
            [
                'usuario'            => 'camila.vasquez',
                'nombre'             => 'Camila',
                'primer_apellido'    => 'Vásquez',
                'segundo_apellido'   => 'Zúñiga',
                'correo_electronico' => 'camila.vasquez@mineduc.cl',
                'cod_perfil'         => 3,
                'cod_departamento'   => 4,
                'cod_usuario'        => 4,
                'cod_estado_usuario' => 1,
                'password'           => Hash::make('123456789'),
            ],
            [
                'usuario'            => 'victoria.parra',
                'nombre'             => 'Victoria',
                'primer_apellido'    => 'Parra',
                'segundo_apellido'   => 'Moreno',
                'correo_electronico' => 'victoria.parra@mineduc.cl',
                'cod_perfil'         => 2,
                'cod_departamento'   => 2,
                'cod_usuario'        => 42,
                'cod_estado_usuario' => 1,
                'password'           => Hash::make('123456789'),
            ],
            [
                'usuario'            => 'renzo.molina',
                'nombre'             => 'Renzo',
                'primer_apellido'    => 'Molina',
                'segundo_apellido'   => 'Pardo',
                'correo_electronico' => 'renzo.pardo@mineduc.cl',
                'cod_perfil'         => 1,
                'cod_departamento'   => 6,
                'cod_usuario'        => 21,
                'cod_estado_usuario' => 1,
                'password'           => Hash::make('123456789'),
            ],
        ]);
    }
}
