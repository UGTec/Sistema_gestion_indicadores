<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicador_proyeccion_mensual', function (Blueprint $table) {
            $table->id();

            // FK al indicador
            $table->unsignedInteger('cod_indicador');
            $table->foreign('cod_indicador')->references('cod_indicador')->on('indicador')->onDelete('cascade');

            // Año/Mes + valor proyectado
            $table->unsignedSmallInteger('anio');  // usar 'anio' para evitar issues con comillas
            $table->unsignedTinyInteger('mes');   // en PostgreSQL será smallint, ok
            $table->decimal('valor', 14, 2)->default(0);

            // Opcional: quién creó/actualizó la proyección
            $table->unsignedInteger('cod_usuario')->nullable();

            $table->timestamps();

            // Un indicador no puede tener dos proyecciones para el mismo mes/año
            $table->unique(['cod_indicador', 'anio', 'mes'], 'uniq_indicador_anio_mes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_proyeccion_mensual');
    }
};
