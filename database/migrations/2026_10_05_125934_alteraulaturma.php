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
        Schema::table('aulas', function (Blueprint $table) {
            $table->unsignedBigInteger('turma_id')->nullable()->after('horario_id');
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->dropUnique(['data_aula', 'horario_id']);
            $table->unique(['data_aula', 'horario_id','turma_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
