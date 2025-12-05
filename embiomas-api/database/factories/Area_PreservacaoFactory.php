<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Area_PreservacaoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_ap' => $this->faker->word,
            'descricao_ap' => $this->faker->paragraph,
            'bioma_id' => \App\Models\Bioma::factory(),
            'tipoap_id' => \App\Models\Tipo_Area_Preservacao::factory(),
            'imagem_ap' => $this->faker->imageUrl,
            'area_geografica' => json_encode(['lat' => $this->faker->latitude, 'lng' => $this->faker->longitude]),
        ];
    }
}
