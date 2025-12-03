<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HidrografiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_hidrografia,
            'nome' => $this->nome_hidrografia,
            'descricao' => $this->descricao_hidrografia,
            'tipo' => $this->tipo_hidrografia,
            'imagem_url' => $this->imagem_hidrografia ? url('storage/' . $this->imagem_hidrografia) : null,
        ];
    }
}
