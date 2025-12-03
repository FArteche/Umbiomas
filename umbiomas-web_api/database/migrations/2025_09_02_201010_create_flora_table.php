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
        Schema::create('flora', function (Blueprint $table) {
            $table->id('id_flora');
            $table->string('nome_flora', 50);
            $table->string('nome_cientifico_flora', 100);
            $table->string('familia_flora', 100);
            $table->string('imagem_flora',255)->nullable();
            $table->text('descricao_flora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flora');
    }
};
