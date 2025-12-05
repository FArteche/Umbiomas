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
        Schema::create('sugestoes', function (Blueprint $table) {
            $table->id('id_sugestoes');
            $table->text('texto_sugestao');
            $table->timestamp('lido_em')->nullable();
            $table->foreignId('postador_id')->constrained('info_postador', 'id_postador')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sugestoes');
    }
};
