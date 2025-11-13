<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Tipo_CSEFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_tipocse' => $this->faker->word,
        ];
    }
}
