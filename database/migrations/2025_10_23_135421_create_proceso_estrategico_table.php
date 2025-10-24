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
        Schema::create('proceso_estrategico', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_proceso', 80)->unique()->nullable(false);
            $table->timestamps();
        });

        Schema::table('indicador_mensual', function (Blueprint $table) {

            $table->unsignedBigInteger('cod_proceso_estrategico')->nullable()->after('cod_usuario_modificacion');

            // Definición de la clave foránea
            $table->foreign('cod_proceso_estrategico')
                ->references('id')
                ->on('proceso_estrategico')
                // 'onDelete('restrict')' es el comportamiento por defecto de MySQL,
                // pero es buena práctica especificarlo.
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Eliminar la clave foránea de 'indicador_mensual'
        Schema::table('indicador_mensual', function (Blueprint $table) {
            // Se debe eliminar la clave foránea ANTES de eliminar la columna
            $table->dropForeign(['cod_proceso_estrategico']);

            // Se elimina la columna
            $table->dropColumn('cod_proceso_estrategico');
        });

        Schema::dropIfExists('proceso_estrategico');
    }
};
