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
        Schema::create('perfil_permiso', function (Blueprint $table) {
            $table->decimal('cod_perfil', 2, 0);
            $table->decimal('cod_permiso', 2, 0);

            $table->primary(['cod_perfil', 'cod_permiso']);
            $table->foreign('cod_perfil')->references('cod_perfil')->on('perfil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_permiso');
    }
};
