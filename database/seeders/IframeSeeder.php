<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IframeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('iframes')->insert([
            [
<<<<<<< HEAD
                'name' => 'Ejemplo de iframe',
                'url' => 'https://app.powerbi.com/view?r=eyJrIjoiNThjZTk0YjItMjYwZS00OWI1LThhMzMtODg1MTM4OGFkOWFhIiwidCI6IjJmODQ4YjNiLTRiMTItNDkxNy1hZDQ3LTU5Y2I4N2JiZDdmYyJ9',
                'description' => 'Este es un ejemplo de iframe para fines de demostración.',
                'width' => '800px',
                'height' => '600px',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iframe inactivo',
                'url' => 'https://eldelassombras.cl',
                'description' => 'Este iframe está actualmente inactivo.',
                'width' => '100%',
                'height' => 'auto',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
=======
                'name'        => 'Ejemplo de iframe',
                'url'         => 'https://app.powerbi.com/view?r=eyJrIjoiNThjZTk0YjItMjYwZS00OWI1LThhMzMtODg1MTM4OGFkOWFhIiwidCI6IjJmODQ4YjNiLTRiMTItNDkxNy1hZDQ3LTU5Y2I4N2JiZDdmYyJ9',
                'description' => 'Este es un ejemplo de iframe para fines de demostración.',
                'width'       => '800px',
                'height'      => '600px',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Iframe inactivo',
                'url'         => 'https://eldelassombras.cl',
                'description' => 'Este iframe está actualmente inactivo.',
                'width'       => '100%',
                'height'      => 'auto',
                'is_active'   => false,
                'created_at'  => now(),
                'updated_at'  => now(),
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
            ],
        ]);
    }
}
