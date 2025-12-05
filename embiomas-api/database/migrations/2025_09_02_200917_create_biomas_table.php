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
        Schema::create('biomas', function (Blueprint $table) {
            $table->id('id_bioma');
            $table->string('nome_bioma', 100);
            $table->text('descricao_bioma');
            $table->string('imagem_bioma')->nullable();
            $table->integer('populacao_bioma');
            $table->json('area_geografica')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biomas');
    }
};
