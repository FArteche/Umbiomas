<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSugestaoRequest;
use App\Http\Resources\Api\V1\SugestaoResource;
use App\Models\Info_Postador;
use App\Models\Sugestoes;
use Illuminate\Support\Facades\DB;

class SugestaoController extends Controller
{
    public function store(StoreSugestaoRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // 1. Encontra ou cria o postador
                $postador = Info_Postador::firstOrCreate(
                    // 1º Array: Condição para a busca (deve ser um campo único como o email)
                    [
                        'email_postador' => $request->input('postador.email')
                    ],
                    // 2º Array: Dados para usar APENAS se precisar criar um novo registro
                    [
                        'nome_postador' => $request->input('postador.nome'),
                        'telefone_postador' => $request->input('postador.telefone'),
                        'instituicao_postador' => $request->input('postador.instituicao'),
                        'ocupacao_postador' => $request->input('postador.ocupacao'),
                    ]
                );

                // 2. Cria a sugestão
                Sugestoes::create([
                    'texto_sugestao' => $request->input('sugestao.texto'),
                    'postador_id' => $postador->id_postador,
                ]);
            });

            // Se tudo deu certo, retorna uma resposta de sucesso sem conteúdo.
            return response()->json(['message' => 'Sugestão enviada com sucesso!'], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao enviar a sugestão.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
