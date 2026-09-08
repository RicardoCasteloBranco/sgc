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
        Schema::table('pareceres_tecnicos', function(Blueprint $table){
            $table->dropColumn([
                'mime_type',
                'name',
                'file_data',
            ]);

            $table->string('protocolo_eletronico')->nullable();
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
