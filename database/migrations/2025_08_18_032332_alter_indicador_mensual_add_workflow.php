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
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->string('estado', 40)->default('por_informar');
            $table->text('observaciones')->nullable(); // observación visible del ciclo
            $table->timestamp('enviado_revisor_at')->nullable();
            $table->timestamp('enviado_control_at')->nullable();
            $table->timestamp('enviado_jefatura_at')->nullable();
            $table->timestamp('aprobado_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->dropColumn(['estado', 'observaciones', 'enviado_revisor_at', 'enviado_control_at', 'enviado_jefatura_at', 'aprobado_at']);
        });
    }
};
