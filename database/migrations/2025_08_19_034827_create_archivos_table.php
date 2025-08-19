<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_original');
            $table->string('nombre_guardado');
            $table->string('ruta');
            $table->string('mime_type');
            $table->integer('tamanho');
            $table->morphs('archivable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('archivos');
    }
};
