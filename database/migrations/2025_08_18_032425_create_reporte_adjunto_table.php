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
        Schema::create('reporte_adjunto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cod_indicador');
            $table->unsignedSmallInteger('mes');
            $table->unsignedSmallInteger('año');
            $table->string('nombre_original');
            $table->string('path'); // storage/app/public/...
            $table->unsignedInteger('cod_usuario');
            $table->timestamps();

            $table->index(['cod_indicador', 'mes', 'año']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_adjunto');
    }
};
