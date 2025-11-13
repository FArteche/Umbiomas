<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HidrografiaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_hidrografia' => $this->faker->word,
            'descricao_hidrografia' => $this->faker->paragraph,
            'tipo_hidrografia' => $this->faker->word,
            'imagem_hidrografia' => $this->faker->imageUrl,
            'bioma_id' => \App\Models\Bioma::factory(),
        ];
    }
}
