<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RelevoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_relevo' => $this->faker->word,
            'descricao_relevo' => $this->faker->paragraph,
            'tipo_relevo' => $this->faker->word,
            'imagem_relevo' => $this->faker->imageUrl,
            'bioma_id' => \App\Models\Bioma::factory(),
        ];
    }
}
