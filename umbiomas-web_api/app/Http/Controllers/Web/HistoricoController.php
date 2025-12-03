<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bioma;
use App\Models\Hist_Alteracao_Bioma;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inicia a construção da query, já carregando os relacionamentos para evitar N+1 queries
        $query = Hist_Alteracao_Bioma::with(['user', 'loggable']);

        // 2. Filtro por TIPO DE ALTERAÇÃO (criacao, edicao, exclusao)
        if ($request->filled('tipo_alteracao')) {
            $query->where('tipo_alteracao', $request->tipo_alteracao);
        }

        // 3. Filtro por BIOMA
        if ($request->filled('bioma_id')) {
            // Filtra o histórico onde o objeto alterado ('loggable')
            // é do tipo 'Bioma' e tem o ID correspondente.
            $query->where('loggable_type', Bioma::class)
                  ->where('loggable_id', $request->bioma_id);
        }

        // 4. Ordenação (ASC ou DESC)
        $sortDirection = $request->input('sort', 'desc'); // 'desc' (mais recente) é o padrão
        $query->orderBy('created_at', $sortDirection);

        // 5. Executa a query com paginação
        $historico = $query->paginate(20)->withQueryString();

        // 6. Busca todos os biomas para popular o dropdown de filtro
        $biomas = Bioma::orderBy('nome_bioma')->get();

        // 7. Retorna a view com os dados
        return view('admin.historico.index', compact('historico', 'biomas'));
    }
}
