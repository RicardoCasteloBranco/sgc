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
        Schema::create('graduacoes', function (Blueprint $table) {
            $table->id();
            $table->string('extenso');
            $table->string('abreviado');
            $table->timestamps();
        });

        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->bigInteger('matricula')->nullable();
            $table->bigInteger('numfunc')->nullable();
            $table->string('cpf',11)->unique();
            $table->unsignedBigInteger('graduacao_id');
            $table->foreign('graduacao_id')->references('id')->on('graduacoes')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('graduacoes')->insert([
            ['extenso'=> "Coronel",'abreviado'=>"Cel"],
            ['extenso'=> "Tenente Coronel",'abreviado'=>"Ten Cel"],
            ['extenso'=> "Major",'abreviado'=>"Maj"],
            ['extenso'=> "Capitão",'abreviado'=>"Cap"],
            ['extenso'=> "1º Tenente",'abreviado'=>"1º Ten"],
            ['extenso'=> "2º Tenente",'abreviado'=>"2º Tenente"],
            ['extenso'=> "Aspirante",'abreviado'=>"Asp"],
            ['extenso'=> "Cadete",'abreviado'=>"Cad"],
            ['extenso'=> "Aluno Curso de Habilitação de Oficiais",'abreviado'=>"Al CHO"],
            ['extenso'=> "SubTenente",'abreviado'=>"Sub Ten"],
            ['extenso'=> "1º Sargento",'abreviado'=>"1º Sgt"],
            ['extenso'=> "2º Sargento",'abreviado'=>"2º Sgt"],
            ['extenso'=> "3º Sargento",'abreviado'=>"3º Sgt"],
            ['extenso'=> "Aluno do Curso de Formação de Sargentos",'abreviado'=>"Al CFS"],
            ['extenso'=> "Cabo",'abreviado'=>"Cb"],
            ['extenso'=> "Soldado",'abreviado'=>"Sd"],
            ['extenso'=> "Aluno do Curso de Formação de Praças",'abreviado'=>"Al CFHP"],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('graduacoes');
    }
};
