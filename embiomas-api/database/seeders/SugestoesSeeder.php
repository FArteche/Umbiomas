<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sugestoes; // Importe o Model

class SugestoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sugestoes::create([
            'texto_sugestao' => 'Vocês poderiam adicionar uma seção sobre os tipos de solo de cada bioma. Seria muito útil para estudantes de agronomia.',
            'postador_id' => 1,
            'lido_em' => null, // Não lido
        ]);

        Sugestoes::create([
            'texto_sugestao' => 'O aplicativo está ótimo! Uma sugestão seria permitir o upload de vídeos curtos nos posts, além de fotos.',
            'postador_id' => 2,
            'lido_em' => now(), // Marcado como lido agora
        ]);
    }
}
