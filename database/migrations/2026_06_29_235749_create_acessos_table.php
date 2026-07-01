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
        Schema::create('acessos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('perfil_id');
            $table->unsignedBigInteger('menu_id');
            $table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('acessos')->insert([
            ['perfil_id' => 1, 'menu_id' => 1],
            ['perfil_id' => 1, 'menu_id' => 2],
            ['perfil_id' => 1, 'menu_id' => 3],
            ['perfil_id' => 1, 'menu_id' => 4],
            ['perfil_id' => 1, 'menu_id' => 5],
            ['perfil_id' => 1, 'menu_id' => 6],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acessos');
    }
};
