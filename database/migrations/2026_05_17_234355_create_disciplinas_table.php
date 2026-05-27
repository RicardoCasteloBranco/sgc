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
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('abreviacao');
            $table->text('ementa')->nullable();
            $table->bigInteger('carga_horaria')->unsigned()->default(0);
            $table->text('conhecimentos')->nullable();
            $table->text('habilidades')->nullable();
            $table->text('atitudes')->nullable();
            $table->longText('referencias')->nullable();
            $table->unsignedBigInteger('projeto_id');
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas');
    }
};
