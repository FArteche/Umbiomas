<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Regras para os dados do Postador
            'postador.nome' => 'required|string|max:100',
            'postador.email' => 'required|email|max:100',
            'postador.telefone' => 'nullable|string|max:20',
            'postador.instituicao' => 'nullable|string|max:100',
            'postador.ocupacao' => 'nullable|string|max:100',

            // Regras para os dados do Post
            'post.titulo' => 'required|string|max:200',
            'post.texto' => 'required|string',
            'post.bioma_id' => 'required|exists:biomas,id_bioma',

            // Regra para a imagem (mídia)
            'post.midia' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ];
    }
}
