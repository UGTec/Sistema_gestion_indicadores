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
        Schema::create('workflow_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cod_indicador');
            $table->unsignedSmallInteger('mes');
            $table->unsignedSmallInteger('año');
            $table->string('accion', 60); // enviar_a_revisor, aprobar_revisor, devolver, etc.
            $table->string('de_estado', 40)->nullable();
            $table->string('a_estado', 40)->nullable();
            $table->unsignedInteger('cod_usuario');
            $table->text('mensaje')->nullable();
            $table->timestamps();
            $table->index(['cod_indicador', 'mes', 'año']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_log');
    }
};
