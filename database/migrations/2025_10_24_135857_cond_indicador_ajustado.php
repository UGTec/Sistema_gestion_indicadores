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
            SELECT setval(pg_get_serial_sequence('indicador', 'cod_indicador'), (SELECT MAX(cod_indicador) FROM indicador))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
    		SELECT setval(pg_get_serial_sequence('indicador', 'cod_indicador'), 1, false)
	");
    }
};
