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
        Schema::create('area_preservacao', function (Blueprint $table) {
            $table->id('id_ap');
            $table->string('nome_ap', 100);
            $table->text('descricao_ap');
            $table->string('imagem_ap')->nullable();
            $table->json('area_geografica')->nullable();
            $table->foreignId('bioma_id')->constrained('biomas', 'id_bioma')->onDelete('cascade');
            $table->foreignId('tipoap_id')->constrained('tipo_area_preservacao', 'id_tipoap')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_preservacao');
    }
};
