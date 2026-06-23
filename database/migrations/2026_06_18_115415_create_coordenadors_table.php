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
        Schema::create('coordenadores', function (Blueprint $table) {
            $table->id();
            $table->string('graduacao');
            $table->date('data_designacao')->nullable();
            $table->string('parecer_tecnico');
            $table->unsignedBigInteger('pessoa_id');
            $table->unsignedBigInteger('turma_id');
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordenadores');
    }
};
