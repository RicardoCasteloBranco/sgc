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
        Schema::create('perfil_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('perfil_id');
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
            $table->foreign('perfil_id')->references('id')->on('perfils')->onCascade('delete');
            $table->timestamps();
        });
        DB::table('perfil_usuarios')->insert([
            ['user_id' => 1, 'perfil_id' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_usuarios');
    }
};
