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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_interno', 20);
            $table->string('placa', 20);
            $table->integer('capacidad');
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->tinyInteger('estado');
            $table->unsignedBigInteger('empresa_afiliada_id');
            $table->unsignedBigInteger('conductor_id');
            $table->timestamps();
            $table->foreign('conductor_id')->references('id')->on('conductores')->onDelete('cascade');
            $table->foreign('empresa_afiliada_id')->references('id')->on('empresa_afiliada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
