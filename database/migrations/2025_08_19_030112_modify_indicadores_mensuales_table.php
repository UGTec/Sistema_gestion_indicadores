<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up()
    {
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->dropPrimary(['cod_indicador', 'mes', 'año']);
            $table->id()->first();

            // Permitir superar la meta
            $table->decimal('resultado', 12, 2)->nullable()->change();

            // Agregar relación con usuario que modifica
            $table->decimal('cod_usuario_modificacion', 2, 0)->nullable();
            $table->foreign('cod_usuario_modificacion')->references('cod_usuario')->on('usuario');
        });
    }

    public function down()
    {
        Schema::table('indicador_mensual', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->primary(['cod_indicador', 'mes', 'año']);
            $table->dropColumn('cod_usuario_modificacion');
        });
    }
};
