<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('departamento', function (Blueprint $table) {
            $table->decimal('cod_departamento', 2, 0)->primary();
            $table->string('departamento', 75)->nullable();
            $table->decimal('cod_division', 2, 0)->nullable();

            $table->foreign(columns: 'cod_division')->references('cod_division')->on('division');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departamento');
    }
};
