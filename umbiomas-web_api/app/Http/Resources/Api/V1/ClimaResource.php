<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClimaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_clima,
            'nome' => $this->nome_clima,
            'descricao' => $this->descricao_clima,
            'imagem_url' => $this->imagem_clima ? url('storage/' . $this->imagem_clima) : null,
            'tambem_presente_em' => $this->whenLoaded('biomas', function () {
                return $this->biomas->pluck('nome_bioma');
            }),
        ];
    }
}
