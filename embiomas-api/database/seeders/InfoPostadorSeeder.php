<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info_Postador; // Importe o Model

class InfoPostadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Info_Postador::create([
            'nome_postador' => 'João da Silva',
            'email_postador' => 'joao.silva@example.com',
            'telefone_postador' => '55999887766',
            'instituicao_postador' => 'Universidade Exemplo',
            'ocupacao_postador' => 'Estudante de Biologia',
        ]);

        Info_Postador::create([
            'nome_postador' => 'Maria Oliveira',
            'email_postador' => 'maria.oliveira@example.com',
            'telefone_postador' => '55988776655',
            'instituicao_postador' => 'Instituto de Pesquisa',
            'ocupacao_postador' => 'Pesquisadora',
        ]);

    }
}
