<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BiomaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_bioma' => $this->faker->word,
            'descricao_bioma' => $this->faker->paragraph,
            'imagem_bioma' => $this->faker->imageUrl(),
            'populacao_bioma'=> $this->faker->numberBetween(1000, 1000000),
        ];
    }
}
