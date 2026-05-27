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
        Schema::create('centro_ensinos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sigla');
            $table->unsignedBigInteger('centro_ensino_id')->nullable();
            $table->timestamps();
        });
        Schema::table('centro_ensinos', function (Blueprint $table) {
            $table->foreign('centro_ensino_id')->references('id')->nullable()->on('centro_ensinos')->onDelete('set null');
        });
        DB::table('centro_ensinos')->insert([
            ['nome' => 'Diretoria de Ensino, Instrução e Pesquisa', 'sigla' => 'DEIP', 'centro_ensino_id' => null],
            ['nome' => 'Academia de Polícia Militar do Paudalho', 'sigla' => 'APMP', 'centro_ensino_id' => 1],
            ['nome' => 'Centro de Formação e Aperfeiçoamento de Praças', 'sigla' => 'CFAP', 'centro_ensino_id' => 1],
            ['nome' => 'Centro de Treinamento Tático', 'sigla' => 'CTT', 'centro_ensino_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centro_ensinos');
    }
};
