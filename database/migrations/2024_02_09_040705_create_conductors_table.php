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
        Schema::create('conductores', function (Blueprint $table) {
            $table->id();
            $table->string('numero_identificacion', 20);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('direccion', 255);
            $table->string('telefono', 20);
            $table->string('numero_licencia', 20);
            $table->date('fecha_vencimiento_licencia');
            $table->double('salario');
            $table->unsignedBigInteger('empresa_afiliada_id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_afiliada_id')->references('id')->on('empresa_afiliada')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores');
    }
};
