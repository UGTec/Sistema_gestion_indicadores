<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Primero eliminar las claves foráneas que dependen de esta columna
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->dropForeign(['cod_indicador']);
        });

        // Cambiar el tipo de columna a serial (autoincremental)
        DB::statement('ALTER TABLE indicador ALTER COLUMN cod_indicador TYPE integer');
        DB::statement('ALTER TABLE indicador ALTER COLUMN cod_indicador SET NOT NULL');
        DB::statement('CREATE SEQUENCE indicador_cod_indicador_seq OWNED BY indicador.cod_indicador');
        DB::statement('ALTER TABLE indicador ALTER COLUMN cod_indicador SET DEFAULT nextval(\'indicador_cod_indicador_seq\')');

        // Recrear las claves foráneas
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->foreign('cod_indicador')->references('cod_indicador')->on('indicador');
        });
    }

    public function down()
    {
        // Revertir los cambios si es necesario
    }
};
