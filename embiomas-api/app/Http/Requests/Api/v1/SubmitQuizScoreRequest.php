<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizScoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bioma_id' => 'required|exists:biomas,id_bioma',
            'score' => 'required|integer|min:0|max:10',
            'postador' => 'required|array',
            'postador.nome' => 'required|string|max:100',
            'postador.email' => 'required|email|max:100',
        ];
    }
}
