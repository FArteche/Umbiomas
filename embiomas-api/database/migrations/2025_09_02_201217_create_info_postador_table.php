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
        Schema::create('info_postador', function (Blueprint $table) {
            $table->id('id_postador');
            $table->string('nome_postador', 100);
            $table->string('email_postador', 150)->nullable();
            $table->string('telefone_postador', 30)->nullable();
            $table->string('instituicao_postador', 150)->nullable();
            $table->string('ocupacao_postador', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_postador');
    }
};
