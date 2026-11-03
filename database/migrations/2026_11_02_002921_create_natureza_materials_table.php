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
        DB::table('natureza_materiais')->insert([
            ['descricao' => 'Material de Consumo'],
            ['descricao' => 'Material Permanente'],
            ['descricao' => 'Material Bélico'],
            ['descricao' => 'Bolsa Formação'],
            ['descricao' => 'Gastos com Pessoal'],
            ['descricao' => 'Custo de Transporte'],
            ['descricao' => 'Custo de Viagem'],
            ['descricao' => 'Custo de Manutenção']
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('natureza_materials');
    }
};
