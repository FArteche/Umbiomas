<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Area_PreservacaoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_ap,
            'nome' => $this->nome_ap,
            'descricao' => $this->descricao_ap,
            'imagem_url' => $this->imagem_ap ? url('storage/' . $this->imagem_ap) : null,
            'localizacao' => $this->area_geografica,

            'tipo' => $this->whenLoaded('tipoap', function () {
                return [
                    'id' => $this->tipoap->id_tipoap,
                    'nome' => $this->tipoap->nome_tipoap,
                ];
            }),
        ];
    }
}
