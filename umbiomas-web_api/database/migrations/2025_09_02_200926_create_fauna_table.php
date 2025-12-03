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
        Schema::create('fauna', function (Blueprint $table) {
            $table->id('id_fauna');
            $table->string('nome_fauna', 50);
            $table->string('nome_cientifico_fauna', 100);
            $table->string('familia_fauna', 100);
            $table->string('imagem_fauna',255)->nullable();
            $table->text('descricao_fauna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fauna');
    }
};
