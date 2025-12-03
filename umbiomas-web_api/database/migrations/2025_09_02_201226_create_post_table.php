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
        Schema::create('post', function (Blueprint $table) {
            $table->id('id_post');
            $table->string('midia_post', 255)->nullable();
            $table->string('titulo_post', 200);
            $table->text('texto_post');
            $table->boolean('aprovado_post')->nullable()->default(null);
            $table->foreignId('bioma_id')->constrained('biomas', 'id_bioma')->onDelete('cascade');
            $table->foreignId('postador_id')->constrained('info_postador', 'id_postador')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
