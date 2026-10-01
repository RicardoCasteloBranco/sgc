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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        try {
            DB::table('aulas')->truncate();
            DB::table('horarios')->truncate();
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }

        Schema::table('horarios', function(Blueprint $table){
            $table->dropForeign(['turma_id']);
            $table->dropColumn('turma_id');
            $table->unsignedBigInteger('projeto_id')->nullable();
        });
        Schema::table('horarios', function(Blueprint $table){
            $table->foreign('projeto_id')->references('id')->on('projetos')->onDelete('cascade');
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
