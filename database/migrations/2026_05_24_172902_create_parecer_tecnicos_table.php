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
        Schema::create('pareceres_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('numero')->unsigned();
            $table->date('validade');
            $table->binary('arquivo');
            $table->text('nome_arquivo');
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
        Schema::dropIfExists('pareceres_tecnicos');
    }
};
