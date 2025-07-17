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
        Schema::create('tipo_indicador', function (Blueprint $table) {
            $table->decimal('cod_tipo_indicador', 2, 0)->primary();
            $table->string('tipo_indicador', 10)->nullable();
            $table->string('descripcion', 75)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_indicadors');
    }
};
