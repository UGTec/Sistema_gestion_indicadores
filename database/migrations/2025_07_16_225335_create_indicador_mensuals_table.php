<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicador_mensual', function (Blueprint $table) {
            //$table->decimal('cod_indicador', 4, 0);
            $table->integer('cod_indicador');
            $table->decimal('numerador', 10, 0)->nullable();
            $table->decimal('denominador', 10, 0)->nullable();
            $table->decimal('mes', 2, 0);
            $table->decimal('año', 4, 0);
            $table->decimal('resultado', 12, 2)->nullable();
            $table->decimal('cod_usuario', 2, 0)->nullable();
            $table->date('fecha_actualizacion')->nullable();

            $table->primary(['cod_indicador', 'mes', 'año']);
            $table->foreign('cod_indicador')->references('cod_indicador')->on('indicador');
            $table->foreign('cod_usuario')->references('cod_usuario')->on('usuario');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_mensual');
    }
};
