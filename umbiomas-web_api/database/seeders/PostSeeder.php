<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post; // Importe o Model

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Posts para o Bioma com ID = 1
        Post::create([
            'titulo_post' => 'Avistamento de Capivaras no Pampa',
            'texto_post' => 'Hoje, durante uma caminhada pela manhã, avistei um grande grupo de capivaras perto do rio. É um sinal de que o ecossistema local está saudável.',
            'aprovado_post' => null, // Pendente de aprovação
            'bioma_id' => 1,
            'postador_id' => 1, // João da Silva
        ]);

        Post::create([
            'titulo_post' => 'A beleza das Araucárias',
            'texto_post' => 'As araucárias são árvores imponentes e fundamentais para a fauna da Mata Atlântica. Precisamos preservar nossas florestas.',
            'aprovado_post' => true, // Já aprovado
            'bioma_id' => 1,
            'postador_id' => 2, // Maria Oliveira
        ]);

        // Post para o Bioma com ID = 2
        Post::create([
            'titulo_post' => 'Onça-pintada na Amazônia',
            'texto_post' => 'Registro fotográfico raro de uma onça-pintada caçando durante a noite. A Amazônia é cheia de vida.',
            'aprovado_post' => false, // Reprovado
            'bioma_id' => 2,
            'postador_id' => 1,
        ]);

    }
}
