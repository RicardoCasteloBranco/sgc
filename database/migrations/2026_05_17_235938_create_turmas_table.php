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
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sigla');
            $table->unsignedBigInteger('unidade_gestora')->nullable();
            $table->foreign('unidade_gestora')->references('id')->on('unidades')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->integer('dias_de_aula_por_semana')->default(0);
            $table->integer('carga_horaria_diaria')->default(0);
            $table->text('edital_docente')->nullable();
            $table->text('edital_discente')->nullable();
            $table->text('portaria_docente')->nullable();
            $table->text('portaria_matricula')->nullable();
            $table->text('portaria_conclusao')->nullable();
            $table->unsignedBigInteger('projeto_id');
            $table->unsignedBigInteger('unidade_id');
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('unidades')->insert([
            ['nome' => 'Diretoria Integrada Metropolitana', 'sigla' => 'DIM', 'unidade_gestora' => null],
            ['nome' => 'Diretoria Integrada do Interior I', 'sigla' => 'Dinter 1', 'unidade_gestora' => null],
            ['nome' => 'Diretoria Integrada do Interior II', 'sigla' => 'Dinter 2', 'unidade_gestora' => null],
            ['nome' => 'Diretoria Integrada Especializada', 'sigla' => 'DIRESP', 'unidade_gestora' => null],
            ['nome' => 'Diretoria de Ensino, Instrução e Pesquisa', 'sigla' => 'DEIP', 'unidade_gestora' => null],
            ['nome' => '1º Batalhão de Polícia Militar', 'sigla' => '1º BPM', 'unidade_gestora' => 1],
            ['nome' => '2º Batalhão de Polícia Militar', 'sigla' => '2º BPM', 'unidade_gestora' => 2],
            ['nome' => '3º Batalhão de Polícia Militar', 'sigla' => '3º BPM', 'unidade_gestora' => 3],
            ['nome' => '4º Batalhão de Polícia Militar', 'sigla' => '4º BPM', 'unidade_gestora' => 2],
            ['nome' => '5º Batalhão de Polícia Militar', 'sigla' => '5º BPM', 'unidade_gestora' => 3],
            ['nome' => '6º Batalhão de Polícia Militar', 'sigla' => '6º BPM', 'unidade_gestora' => 1],
            ['nome' => '7º Batalhão de Polícia Militar', 'sigla' => '7º BPM', 'unidade_gestora' => 3],
            ['nome' => '8º Batalhão de Polícia Militar', 'sigla' => '8º BPM', 'unidade_gestora' => 3],
            ['nome' => '9º Batalhão de Polícia Militar', 'sigla' => '9º BPM', 'unidade_gestora' => 2],
            ['nome' => '10º Batalhão de Polícia Militar', 'sigla' => '10º BPM', 'unidade_gestora' => 2],
            ['nome' => '11º Batalhão de Polícia Militar', 'sigla' => '11º BPM', 'unidade_gestora' => 1],
            ['nome' => '12º Batalhão de Polícia Militar', 'sigla' => '12º BPM', 'unidade_gestora' => 1],
            ['nome' => '13º Batalhão de Polícia Militar', 'sigla' => '13º BPM', 'unidade_gestora' => 1],
            ['nome' => '14º Batalhão de Polícia Militar', 'sigla' => '14º BPM', 'unidade_gestora' => 3],
            ['nome' => '15º Batalhão de Polícia Militar', 'sigla' => '15º BPM', 'unidade_gestora' => 2],
            ['nome' => '16º Batalhão de Polícia Militar', 'sigla' => '16º BPM', 'unidade_gestora' => 1],
            ['nome' => '17º Batalhão de Polícia Militar', 'sigla' => '17º BPM', 'unidade_gestora' => 1],
            ['nome' => '18º Batalhão de Polícia Militar', 'sigla' => '18º BPM', 'unidade_gestora' => 1],
            ['nome' => '19º Batalhão de Polícia Militar', 'sigla' => '19º BPM', 'unidade_gestora' => 1],
            ['nome' => '20º Batalhão de Polícia Militar', 'sigla' => '20º BPM', 'unidade_gestora' => 1],
            ['nome' => '21º Batalhão de Polícia Militar', 'sigla' => '21º BPM', 'unidade_gestora' => 2],
            ['nome' => '22º Batalhão de Polícia Militar', 'sigla' => '22º BPM', 'unidade_gestora' => 2],
            ['nome' => '23º Batalhão de Polícia Militar', 'sigla' => '23º BPM', 'unidade_gestora' => 3],
            ['nome' => '24º Batalhão de Polícia Militar', 'sigla' => '24º BPM', 'unidade_gestora' => 2],
            ['nome' => '25º Batalhão de Polícia Militar', 'sigla' => '25º BPM', 'unidade_gestora' => 1],
            ['nome' => '26º Batalhão de Polícia Militar', 'sigla' => '26º BPM', 'unidade_gestora' => 1],
            ['nome' => '27º Batalhão de Polícia Militar', 'sigla' => '27º BPM', 'unidade_gestora' => 2],
            ['nome' => '1ª Companhia Independente de Polícia Militar', 'sigla' => '1ª CIPM', 'unidade_gestora' => 3],
            ['nome' => '2ª Companhia Independente de Polícia Militar', 'sigla' => '2ª CIPM', 'unidade_gestora' => 3],
            ['nome' => '3ª Companhia Independente de Polícia Militar', 'sigla' => '3ª CIPM', 'unidade_gestora' => 2],
            ['nome' => '4ª Companhia Independente de Polícia Militar', 'sigla' => '4ª CIPM', 'unidade_gestora' => 3],
            ['nome' => '5ª Companhia Independente de Polícia Militar', 'sigla' => '5ª CIPM', 'unidade_gestora' => 2],
            ['nome' => '6ª Companhia Independente de Polícia Militar', 'sigla' => '6ª CIPM', 'unidade_gestora' => 2],
            ['nome' => '7ª Companhia Independente de Polícia Militar', 'sigla' => '7ª CIPM', 'unidade_gestora' => 3],
            ['nome' => '8ª Companhia Independente de Polícia Militar', 'sigla' => '8ª CIPM', 'unidade_gestora' => 2],
            ['nome' => '9ª Companhia Independente de Polícia Militar', 'sigla' => '9ª CIPM', 'unidade_gestora' => 3],
            ['nome' => '10ª Companhia Independente de Polícia Militar', 'sigla' => '10ª CIPM', 'unidade_gestora' => 2],
            ['nome' => 'Batalhão de Polícia de Choque', 'sigla' => 'BPCHoque', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia Rodoviária', 'sigla' => 'BPRv', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia Ambiental', 'sigla' => 'BPMA', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia de Trânsito', 'sigla' => 'BPTran', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia de Rádio Patrulha', 'sigla' => 'BPRP', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia de Guardas', 'sigla' => 'BPGd', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Operações Especiais', 'sigla' => 'BOPE', 'unidade_gestora' => 4],
            ['nome' => 'Batalhão de Polícia em Áreas Turísticas ', 'sigla' => 'BPTur', 'unidade_gestora' => 4],
            ['nome' => 'Regimento de Policiamento Montado', 'sigla' => 'RPMont', 'unidade_gestora' => 4],
            ['nome' => '1º Batalhão Integrado Especializado', 'sigla' => '1º BIESP', 'unidade_gestora' => 4],
            ['nome' => '2º Batalhão Integrado Especializado', 'sigla' => '2º BIESP', 'unidade_gestora' => 4],
            ['nome' => 'Companhia Independente de Policiamento com Motos', 'sigla' => 'CIPMotos', 'unidade_gestora' => 4],
            ['nome' => 'Companhia Independente de Policiamento com Cães', 'sigla' => 'CIPCães', 'unidade_gestora' => 4],
            ['nome' => 'Academia de Polícia Militar do Paudalho', 'sigla' => 'APMP', 'unidade_gestora' => 5],
            ['nome' => 'Centro de Formação e Aperfeiçoamento de Praças', 'sigla' => 'CFAP', 'unidade_gestora' => 5],
            ['nome' => 'Centro de Treinamento Tático', 'sigla' => 'CTT', 'unidade_gestora' => 5],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};
