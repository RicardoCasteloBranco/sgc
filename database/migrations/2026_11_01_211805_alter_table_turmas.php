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
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropColumn('edital_docente');
            $table->dropColumn('edital_discente');
            $table->dropColumn('portaria_docente');
            $table->dropColumn('portaria_matricula');
            $table->dropColumn('portaria_conclusao');
            $table->double('valor_hora_aula_coordenador', 8, 2)->default(0)->after('carga_horaria_diaria');
            $table->double('valor_hora_aula_instrutor_titular', 8, 2)->default(0)->after('valor_hora_aula_coordenador');
            $table->double('valor_hora_aula_instrutor_secundario', 8, 2)->default(0)->after('valor_hora_aula_instrutor_titular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
