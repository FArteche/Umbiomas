<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelevoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_relevo,
            'nome' => $this->nome_relevo,
            'descricao' => $this->descricao_relevo,
            'tipo' => $this->tipo_relevo,
            'imagem_url' => $this->imagem_relevo ? url('storage/' . $this->imagem_relevo) : null,
        ];
    }
}
