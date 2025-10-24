<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. ESTA MIGRACION ES NECESARIA SOLO CUANDO NO SE CREAN LAS TABLAS POR ALGUN BACKUP EN SQL.
     */
    public function up(): void
    {
        Schema::create('condicional', function (Blueprint $table) {
            $table->unsignedTinyInteger('cod_condicional')->primary();
            $table->string('condicional', 50)->unique()->nullable(false);
            $table->timestamps();
        });

        Schema::table('indicador_mensual', function (Blueprint $table) {
            // 1. Agregar las columnas numéricas que serán claves foráneas
            // Usamos unsignedTinyInteger ya que condicional usa cod_condicional (1 a 3)
            $table->unsignedTinyInteger('condicional_oportunidad')->nullable();
            $table->unsignedTinyInteger('condicional_completitud')->nullable();
            $table->unsignedTinyInteger('condicional_progreso')->nullable();
            $table->unsignedTinyInteger('condicional_riesgo')->nullable();

            // 2. Agregar las columnas 'character varying' (string)
            $table->string('descripcion_oportunidad', 255)->nullable();
            $table->string('descripcion_completitud', 255)->nullable();
            $table->string('descripcion_progreso', 255)->nullable();
            $table->string('descripcion_riesgo', 255)->nullable();
            $table->string('gestiones', 255)->nullable(); // Longitud ajustable

            // 3. Definir las claves foráneas a la tabla 'condicional'
            // 'on delete restrict' es el comportamiento por defecto, pero se especifica para claridad.
            $table->foreign('condicional_oportunidad')->references('cod_condicional')->on('condicional')->onDelete('restrict');
            $table->foreign('condicional_completitud')->references('cod_condicional')->on('condicional')->onDelete('restrict');
            $table->foreign('condicional_progreso')->references('cod_condicional')->on('condicional')->onDelete('restrict');
            $table->foreign('condicional_riesgo')->references('cod_condicional')->on('condicional')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('indicador_mensual', function (Blueprint $table) {
            // 1. Eliminar las claves foráneas primero
            $table->dropForeign(['condicional_oportunidad']);
            $table->dropForeign(['condicional_completitud']);
            $table->dropForeign(['condicional_progreso']);
            $table->dropForeign(['condicional_riesgo']);

            // 2. Eliminar todas las columnas agregadas
            $table->dropColumn([
                'condicional_oportunidad',
                'condicional_completitud',
                'condicional_progreso',
                'condicional_riesgo',
                'descripcion_oportunidad',
                'descripcion_completitud',
                'descripcion_progreso',
                'descripcion_riesgo',
                'gestiones'
            ]);
        });

        Schema::dropIfExists('condicional');
    }
};
