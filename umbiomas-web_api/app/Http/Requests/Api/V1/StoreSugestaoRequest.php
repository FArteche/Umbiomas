<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreSugestaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'postador.nome' => 'required|string|max:100',
            'postador.email' => 'required|email|max:100',
            'postador.telefone' => 'nullable|string|max:20',
            'postador.instituicao' => 'nullable|string|max:100',
            'postador.ocupacao' => 'nullable|string|max:100',

            'sugestao.texto' => 'required|string',
        ];
    }
}
