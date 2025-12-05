<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BiomaListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_bioma,
            'nome' => $this->nome_bioma,
            'imagem_url' => $this->imagem_bioma ? url('storage/' . $this->imagem_bioma) : null,
        ];
    }
}
