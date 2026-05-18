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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sigla');
            $table->text('objetivo_geral');
            $table->longText('objetivos_especificos');
            $table->text('publico_alvo');
            $table->unsignedBigInteger('centro_ensino_id')->nullable();
            $table->foreign('centro_ensino_id')->references('id')->on('centro_ensinos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
