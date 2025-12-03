<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\SubmitQuizScoreRequest;
use App\Models\Bioma;
use App\Models\Fauna;
use App\Models\Flora;
use App\Models\Clima;
use App\Models\Relevo;
use App\Models\Hidrografia;
use App\Models\Caracteristica_SE;
use App\Models\Area_Preservacao;
use App\Models\QuizAttempt;
use App\Models\Info_Postador;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function generateQuiz(Bioma $bioma)
    {
        $perguntas = [];

        // --- Gera 2 perguntas para cada categoria ---

        // Relações Muitos-para-Muitos
        $perguntas = array_merge($perguntas, $this->generateManyToManyQuestion($bioma, 1, [
            'model' => Fauna::class,
            'relation' => 'fauna',
            'id_col' => 'id_fauna',
            'name_col' => 'nome_fauna',
            'img_col' => 'imagem_fauna',
            'tipo_quiz' => 'fauna_imagem',
            'pergunta_texto' => 'Qual destes animais é encontrado no(a) ' . $bioma->nome_bioma . '?',
        ]));

        $perguntas = array_merge($perguntas, $this->generateManyToManyQuestion($bioma, 1, [
            'model' => Flora::class,
            'relation' => 'flora',
            'id_col' => 'id_flora',
            'name_col' => 'nome_flora',
            'img_col' => 'imagem_flora',
            'tipo_quiz' => 'flora_imagem',
            'pergunta_texto' => 'Qual destas plantas é encontrada no(a) ' . $bioma->nome_bioma . '?',
        ]));

        $perguntas = array_merge($perguntas, $this->generateManyToManyQuestion($bioma, 1, [
            'model' => Clima::class,
            'relation' => 'clima',
            'id_col' => 'id_clima',
            'name_col' => 'nome_clima',
            'img_col' => 'imagem_clima',
            'tipo_quiz' => 'clima_texto',
            'pergunta_texto' => 'Qual destes climas é predominante no(a) ' . $bioma->nome_bioma . '?',
        ]));

        $perguntas = array_merge($perguntas, $this->generateManyToManyQuestion($bioma, 1, [
            'model' => Caracteristica_SE::class,
            'relation' => 'caracteristica_se', // Nome do método no Model Bioma
            'id_col' => 'id_cse',
            'name_col' => 'nome_cse',
            'img_col' => 'imagem_cse',
            'tipo_quiz' => 'caracteristica_texto',
            'pergunta_texto' => 'Qual destas características socioeconômicas pertence ao(à) ' . $bioma->nome_bioma . '?',
        ]));

        // Relações Um-para-Muitos
        $perguntas = array_merge($perguntas, $this->generateOneToManyQuestion($bioma, 1, [
            'model' => Relevo::class,
            'relation' => 'relevo', // Nome do método no Model Bioma
            'id_col' => 'id_relevo',
            'name_col' => 'nome_relevo',
            'img_col' => 'imagem_relevo',
            'tipo_quiz' => 'relevo_texto',
            'pergunta_texto' => 'Qual destas formas de relevo é encontrada no(a) ' . $bioma->nome_bioma . '?',
        ]));

        $perguntas = array_merge($perguntas, $this->generateOneToManyQuestion($bioma, 1, [
            'model' => Hidrografia::class,
            'relation' => 'hidrografia', // Nome do método no Model Bioma
            'id_col' => 'id_hidrografia',
            'name_col' => 'nome_hidrografia',
            'img_col' => 'imagem_hidrografia',
            'tipo_quiz' => 'hidrografia_texto',
            'pergunta_texto' => 'Qual destes rios ou bacias banha o(a) ' . $bioma->nome_bioma . '?',
        ]));

        $perguntas = array_merge($perguntas, $this->generateOneToManyQuestion($bioma, 1, [
            'model' => Area_Preservacao::class,
            'relation' => 'area_preservacao', // Nome do método no Model Bioma
            'id_col' => 'id_ap',
            'name_col' => 'nome_ap',
            'img_col' => 'imagem_ap',
            'tipo_quiz' => 'area_preservacao_texto',
            'pergunta_texto' => 'Qual destas Áreas de Preservação fica no(a) ' . $bioma->nome_bioma . '?',
        ]));

        // Embaralha as perguntas e garante que só retornará 10
        shuffle($perguntas);
        return response()->json(array_slice($perguntas, 0, 10));
    }

    public function submitScore(SubmitQuizScoreRequest $request)
    {
        $validated = $request->validated();

        try {
            $attempt = DB::transaction(function () use ($validated) {
                $postador = Info_Postador::firstOrCreate(
                    ['email_postador' => $validated['postador']['email']],
                    ['nome_postador' => $validated['postador']['nome']]
                );

                return QuizAttempt::create([
                    'bioma_id'    => $validated['bioma_id'],
                    'postador_id' => $postador->id_postador,
                    'score'       => $validated['score'],
                ]);
            });

            return response()->json([
                'message' => 'Pontuação registrada com sucesso!',
                'attempt_id' => $attempt->id
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocorreu um erro ao salvar a pontuação.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    //Retorna o ranking semanal para um bioma.
    public function getRanking(Bioma $bioma)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // 2. Constrói a consulta ao banco de dados
        $ranking = QuizAttempt::with('postador')
            ->where('bioma_id', $bioma->id_bioma)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('score', 'DESC')
            ->orderBy('created_at', 'ASC')
            ->take(20)
            ->get();

        // 3. Formata os dados para a API (opcional, mas recomendado)
        $formattedRanking = $ranking->map(function ($attempt, $index) {
            return [
                'posicao' => $index + 1,
                'nome' => $attempt->postador->nome_postador ?? 'Usuário Anônimo',
                'score' => $attempt->score,
                'data' => $attempt->created_at->format('d/m/Y H:i'),
            ];
        });

        // 4. Retorna a lista formatada como JSON
        return response()->json($formattedRanking);
    }

    /**
     * Gera perguntas para relações Muitos-para-Muitos (Fauna, Flora, Clima, CaracteristicaSE).
     */
    private function generateManyToManyQuestion(Bioma $bioma, int $count, array $config)
    {
        $perguntas = [];
        // Pega $count itens corretos deste bioma
        $corretos = $bioma->{$config['relation']}()->inRandomOrder()->take($count)->get();

        foreach ($corretos as $correto) {
            // Pega 3 itens incorretos (que não sejam os que já estão associados a este bioma)
            $corretosIds = $bioma->{$config['relation']}()->pluck($config['id_col']);
            $incorretos = $config['model']::whereNotIn($config['id_col'], $corretosIds)
                ->inRandomOrder()->take(3)->get();

            // Monta as opções
            $opcoes = [];
            $opcoes[] = ['id' => $correto->{$config['id_col']}, 'text' => $correto->{$config['name_col']}];
            foreach ($incorretos as $incorreto) {
                $opcoes[] = ['id' => $incorreto->{$config['id_col']}, 'text' => $incorreto->{$config['name_col']}];
            }
            shuffle($opcoes); // Embaralha as opções

            $perguntas[] = [
                'tipo' => $config['tipo_quiz'],
                'pergunta_texto' => $config['pergunta_texto'],
                'imagem_url' => $correto->{$config['img_col']} ? url('storage/' . $correto->{$config['img_col']}) : null,
                'opcoes' => $opcoes,
                'id_resposta_correta' => $correto->{$config['id_col']},
            ];
        }
        return $perguntas;
    }

    /**
     * Gera perguntas para relações Um-para-Muitos (Relevo, Hidrografia, AreaPreservacao).
     */
    private function generateOneToManyQuestion(Bioma $bioma, int $count, array $config)
    {
        $perguntas = [];
        // Pega $count itens corretos deste bioma
        $corretos = $bioma->{$config['relation']}()->inRandomOrder()->take($count)->get();

        foreach ($corretos as $correto) {
            // Pega 3 itens incorretos (que pertencem a OUTROS biomas)
            $incorretos = $config['model']::where('bioma_id', '!=', $bioma->id_bioma)
                ->inRandomOrder()->take(3)->get();

            $opcoes = [];
            $opcoes[] = ['id' => $correto->{$config['id_col']}, 'text' => $correto->{$config['name_col']}];
            foreach ($incorretos as $incorreto) {
                $opcoes[] = ['id' => $incorreto->{$config['id_col']}, 'text' => $incorreto->{$config['name_col']}];
            }
            shuffle($opcoes);

            $perguntas[] = [
                'tipo' => $config['tipo_quiz'],
                'pergunta_texto' => $config['pergunta_texto'],
                'imagem_url' => $correto->{$config['img_col']} ? url('storage/' . $correto->{$config['img_col']}) : null,
                'opcoes' => $opcoes,
                'id_resposta_correta' => $correto->{$config['id_col']},
            ];
        }
        return $perguntas;
    }
}
