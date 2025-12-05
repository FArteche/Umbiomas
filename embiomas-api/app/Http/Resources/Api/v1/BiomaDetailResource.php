<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BiomaDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_bioma,
            'nome' => $this->nome_bioma,
            'descricao' => $this->descricao_bioma,
            'imagem_url' => $this->imagem_bioma ? url('storage/' . $this->imagem_bioma) : null,
            'populacao' => $this->populacao_bioma,
            'area_geografica' => $this->area_geografica,
        ];
    }
}
