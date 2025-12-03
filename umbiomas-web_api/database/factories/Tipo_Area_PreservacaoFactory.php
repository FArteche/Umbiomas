<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Tipo_Area_PreservacaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_tipoap' => $this->faker->word,
        ];
    }
}
