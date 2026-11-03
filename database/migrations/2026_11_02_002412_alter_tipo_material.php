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
        Schema::create('natureza_materiais', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::table('tipo_materiais', function (Blueprint $table) {
            $table->dropColumn('material_belico');
            $table->unsignedBigInteger('natureza_material_id')->nullable();
            $table->foreign('natureza_material_id')->references('id')->on('natureza_materiais')->onDelete('set null');
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
