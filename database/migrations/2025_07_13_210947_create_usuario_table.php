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
        Schema::create('usuario', function (Blueprint $table) {
            $table->string('usuario', 40)->nullable();
            $table->string('nombre', 40)->nullable();
            $table->string('primer_apellido', 40)->nullable();
            $table->string('segundo_apellido', 40)->nullable();
            $table->string('correo_electronico', 70)->nullable();
            $table->decimal('cod_perfil', 2, 0)->nullable();
            $table->decimal('cod_departamento', 2, 0)->nullable();
            $table->decimal('cod_usuario', 2, 0)->primary();
            $table->decimal('cod_estado_usuario', 1, 0)->nullable();
            $table->string('password');

            $table->foreign('cod_perfil')->references('cod_perfil')->on('perfil');
            $table->foreign('cod_departamento')->references('cod_departamento')->on('departamento');
            $table->foreign('cod_estado_usuario')->references('cod_estado_usuario')->on('estado_usuario');

            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
