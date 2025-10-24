<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            SELECT setval(pg_get_serial_sequence('indicador_proyeccion_mensual', 'id'), (SELECT MAX(id) FROM indicador_proyeccion_mensual))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            SELECT setval(pg_get_serial_sequence('indicador_proyeccion_mensual', 'id'), 1, false)
        ");
    }
};
