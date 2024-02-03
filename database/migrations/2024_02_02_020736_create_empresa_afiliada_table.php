<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresa_afiliada', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 70)->unique();
            $table->string('nombre', 100);
            $table->string('nit', 10);
            $table->string('direccion', 255);
            $table->string('telefono', 20);
            $table->date('fecha_afiliacion');
            $table->tinyInteger('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_afiliada');
    }
};
