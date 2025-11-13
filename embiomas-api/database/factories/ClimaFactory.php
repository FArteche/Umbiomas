<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClimaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_clima' => $this->faker->word,
            'descricao_clima' => $this->faker->paragraph,
            'imagem_clima' => $this->faker->imageUrl,
        ];
    }
}
