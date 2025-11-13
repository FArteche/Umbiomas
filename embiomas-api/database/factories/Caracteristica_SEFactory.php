<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Caracteristica_SEFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_cse' => $this->faker->word,
            'descricao_cse' => $this->faker->paragraph,
            'bioma_id' => \App\Models\Bioma::factory(),
            'imagem_cse' => $this->faker->imageUrl,
            'tipocse_id' => \App\Models\Tipo_CSE::factory(),
        ];
    }
}
