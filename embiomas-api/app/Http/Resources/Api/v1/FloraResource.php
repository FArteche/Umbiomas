<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FloraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_flora,
            'nome' => $this->nome_flora,
            'nome_cientifico' => $this->nome_cientifico_flora,
            'familia' => $this->familia_flora,
            'descricao' => $this->descricao_flora,
            'imagem_url' => $this->imagem_flora ? url('storage/' . $this->imagem_flora) : null,
            'tambem_presente_em' => $this->whenLoaded('biomas', function () {
                return $this->biomas->pluck('nome_bioma');
            }),
        ];
    }
}
