<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Caracteristica_SEResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_cse,
            'nome' => $this->nome_cse,
            'descricao' => $this->descricao_cse,
            'imagem_url' => $this->imagem_cse ? url('storage/' . $this->imagem_cse) : null,

            'tipo' => $this->whenLoaded('tipocse', function () {
                return [
                    'id' => $this->tipocse->id_tipocse,
                    'nome' => $this->tipocse->nome_tipocse,
                ];
            }),
        ];
    }
}
