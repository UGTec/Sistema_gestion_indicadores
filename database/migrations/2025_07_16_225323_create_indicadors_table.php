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
        Schema::create('indicador', function (Blueprint $table) {
            //$table->decimal('cod_indicador', 4, 0)->primary();
            $table->integer('cod_indicador')->primary();
            $table->string('indicador', 4098)->nullable();
            $table->string('objetivo', 4098)->nullable();
            $table->decimal('cod_tipo_indicador', 2, 0)->nullable();
            $table->string('parametro1', 1024)->nullable();
            $table->string('parametro2', 1024)->nullable();
            $table->decimal('cod_usuario', 2, 0)->nullable();
            $table->decimal('meta', 10, 0)->nullable();

            $table->foreign('cod_tipo_indicador')->references('cod_tipo_indicador')->on('tipo_indicador');
            $table->foreign('cod_usuario')->references('cod_usuario')->on('usuario');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador');
    }
};
