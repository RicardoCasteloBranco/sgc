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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->text('edital_docente');
            $table->text('edital_discente');
            $table->text('portaria_docente');
            $table->text('portaria_matricula');
            $table->integer('quantidade_matriculados');
            $table->text('portaria_conclusao');
            $table->integer('quantidade_concluintes');
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
        Schema::dropIfExists('turmas');
    }
};
