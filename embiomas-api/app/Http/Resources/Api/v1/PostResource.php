<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_post,
            'titulo' => $this->titulo_post,
            'texto' => $this->texto_post,
            'midia_url' => $this->midia_post ? url('storage/' . $this->midia_post) : null,
            'data_publicacao' => $this->created_at->toISOString(),
            'postador' => $this->whenLoaded('postador', function () {
                return [
                    'nome' => $this->postador->nome_postador,
                    'instituicao' => $this->postador->instituicao,
                ];
            }),
        ];
    }
}
