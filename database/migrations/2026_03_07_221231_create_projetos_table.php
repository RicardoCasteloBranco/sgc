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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->date('data_aprovacao');
            $table->integer('quantidade_turmas');
            $table->double('custo_hora_aula_por_turma', 15, 2)->default(0);
            $table->double('custo_bolsa_formacao_por_turma', 15, 2)->default(0);
            $table->double('custo_servico_por_turma', 15, 2)->default(0);
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('centro_ensino_id');
            $table->timestamps();
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('centro_ensino_id')->references('id')->on('centro_ensinos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};
