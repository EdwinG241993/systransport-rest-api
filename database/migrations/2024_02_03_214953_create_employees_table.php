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
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->string('numero_identificacion', 10);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('direccion', 255);
            $table->string('telefono', 20);
            $table->string('cargo', 100);
            $table->date('fecha_ingreso');
            $table->double('salario');
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('empresa_afiliada_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('empresa_afiliada_id')->references('id')->on('empresa_afiliada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
