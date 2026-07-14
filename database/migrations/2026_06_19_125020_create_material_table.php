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
        Schema::create('tipo_materiais', function (Blueprint $table){
            $table->id();
            $table->string('descricao');
            $table->boolean('material_belico')->default(false);
            $table->timestamps();
        });

        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_por_turma')->default(1);
            $table->unsignedBigInteger('projeto_id');
            $table->unsignedBigInteger('tipo_material_id');
            $table->double('custo_unitario', 15, 2)->default(0);
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->foreign('tipo_material_id')->references('id')->on('tipo_materiais')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_materiais');
        Schema::dropIfExists('materiais');
    }
};
