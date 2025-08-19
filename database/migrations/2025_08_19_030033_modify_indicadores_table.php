<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::table('indicador', function (Blueprint $table) {
            // Cambiar a autoincremental
            $table->increments('cod_indicador')->change();

            // Agregar campos nuevos
            $table->boolean('cerrado')->default(false);
            $table->dateTime('fecha_cierre')->nullable();
            $table->string('estado')->default('abierto'); // abierto, cerrado, completado
        });
    }

    public function down()
    {
        Schema::table('indicador', function (Blueprint $table) {
            $table->decimal('cod_indicador', 4, 0)->change();
            $table->dropColumn(['cerrado', 'fecha_cierre', 'estado']);
        });
    }
};
