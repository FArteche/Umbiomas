<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaunaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_fauna,
            'nome' => $this->nome_fauna,
            'nome_cientifico' => $this->nome_cientifico_fauna,
            'familia' => $this->familia_fauna,
            'descricao' => $this->descricao_fauna,
            'imagem_url' => $this->imagem_fauna ? url('storage/' . $this->imagem_fauna) : null,
            'tambem_presente_em' => $this->whenLoaded('biomas', function () {
                return $this->biomas->pluck('nome_bioma');
            }),
        ];
    }
}
