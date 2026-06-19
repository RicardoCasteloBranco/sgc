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
        Schema::create('tipo_materiais_belicos', function (Blueprint $table){
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('materiais_belicos', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_por_aluno');
            $table->unsignedBigInteger('projeto_id');
            $table->unsignedBigInteger('tipo_material_belico_id');
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->foreign('tipo_material_belico_id')->references('id')->on('tipo_materiais_belicos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_materiais_belicos');
        Schema::dropIfExists('materiais_belicos');
    }
};
