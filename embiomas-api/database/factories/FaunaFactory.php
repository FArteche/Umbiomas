<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaunaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_fauna' => $this->faker->word,
            'nome_cientifico_fauna' => $this->faker->word,
            'familia_fauna' => $this->faker->word,
            'descricao_fauna' => $this->faker->paragraph,
            'imagem_fauna' => $this->faker->imageUrl,
        ];
    }
}
