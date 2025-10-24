<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            SELECT setval(pg_get_serial_sequence('indicador_mensual', 'id'), (SELECT MAX(id) FROM indicador_mensual))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opcional: puedes resetear la secuencia a 1 si quieres revertir
        DB::statement("
            SELECT setval(pg_get_serial_sequence('indicador_mensual', 'id'), 1, false)
        ");
    }
};
