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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('rota');
            $table->timestamps();
        });

        DB::table('menus')->insert([
            ['titulo' => 'Cursos', 'rota' => 'curso'],
            ['titulo' => 'Calendário', 'rota' => 'calendario'],
            ['titulo' => 'Cadastro de Material Bélico', 'rota' => 'cadastro'],
            ['titulo' => 'Adicionar Usuário', 'rota' => 'register'],
            ['titulo' => 'Perfil de Acesso ao Sistema', 'rota' => 'perfil'],
            ['titulo' => 'Perfil de Usuários do Sistema', 'rota' => 'perfil_usuario'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
