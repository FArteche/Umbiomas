<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StorePostRequest; // Use o Form Request
use App\Http\Resources\Api\V1\PostResource;
use App\Models\Info_Postador;
use App\Models\Post;
use Illuminate\Support\Facades\DB; // Importe a classe DB para transações

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        // DB::transaction garante que todas as operações sejam bem-sucedidas, ou nenhuma será executada.
        try {
            $post = DB::transaction(function () use ($request) {
                // 1. Encontra um postador com o email fornecido ou cria um novo.
                $postador = Info_Postador::firstOrCreate(
                    ['email_postador' => $request->input('postador.email')],
                    [
                        'nome_postador'          => $request->input('postador.nome'),
                        'telefone_postador'      => $request->input('postador.telefone'),
                        'instituicao_postador'   => $request->input('postador.instituicao'),
                        'ocupacao_postador'      => $request->input('postador.ocupacao'),
                    ]
                );

                // 2. Prepara os dados do post
                $postData = [
                    'titulo_post'   => $request->input('post.titulo'),
                    'texto_post'    => $request->input('post.texto'),
                    'bioma_id'      => $request->input('post.bioma_id'),
                    'postador_id'   => $postador->id_postador,
                    'aprovado_post' => null,
                ];

                // 3. Salva a imagem, se uma foi enviada
                if ($request->hasFile('post.midia')) {
                    $path = $request->file('post.midia')->store('posts', 'public');
                    $postData['midia_post'] = $path;
                }

                // 4. Cria o post no banco de dados
                return Post::create($postData);
            });

            // Se a transação for bem-sucedida, retorna o post criado
            return (new PostResource($post))
                ->response()
                ->setStatusCode(201); // 201 Created é o status HTTP correto

        } catch (\Throwable $th) {
            // Se qualquer passo dentro da transação falhar, retorna um erro
            return response()->json([
                'message' => 'Ocorreu um erro ao criar o post.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
