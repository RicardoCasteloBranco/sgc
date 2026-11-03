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
        Schema::table('disciplinas', function (Blueprint $table) {
            $table->integer('qtd_instrutores_titulares')->nullable()->after('carga_horaria');
            $table->integer('qtd_instrutores_secundarios')->nullable()->after('qtd_instrutores_titulares');
            $table->dropColumn('conhecimentos');
            $table->dropColumn('habilidades');
            $table->dropColumn('atitudes');
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
