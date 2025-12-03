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
        Schema::create('bioma_clima', function (Blueprint $table) {
            $table->foreignId('bioma_id')->constrained('biomas', 'id_bioma')->onDelete('cascade');
            $table->foreignId('clima_id')->constrained('clima', 'id_clima')->onDelete('cascade');
            $table->primary(['bioma_id', 'clima_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bioma_clima');
    }
};
