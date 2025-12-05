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
        Schema::create('relevo', function (Blueprint $table) {
            $table->id('id_relevo');
            $table->string('nome_relevo', 100);
            $table->text('descricao_relevo');
            $table->string('tipo_relevo', 100);
            $table->string('imagem_relevo',255)->nullable();
            $table->foreignId('bioma_id')->constrained('biomas', 'id_bioma')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relevo');
    }
};
