<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FloraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_flora' => $this->faker->word,
            'nome_cientifico_flora' => $this->faker->word,
            'familia_flora' => $this->faker->word,
            'descricao_flora' => $this->faker->paragraph,
            'imagem_flora' => $this->faker->imageUrl,
        ];
    }
}
