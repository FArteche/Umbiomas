<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Sugestoes;
use Illuminate\Http\Request;

class SugestoesController extends Controller
{
    public function index()
    {
        // Busca as sugestões, colocando as não lidas primeiro
        $sugestoes = Sugestoes::with('postador')
                            ->orderByRaw('lido_em IS NULL DESC, created_at DESC')
                            ->paginate(20);

        return view('admin.sugestoes.index', compact('sugestoes'));
    }

    public function show(Sugestoes $sugestao)
    {
        // Lógica principal: Se a sugestão ainda não foi lida, marque-a como lida agora.
        if (is_null($sugestao->lido_em)) {
            $sugestao->update(['lido_em' => now()]);
        }

        $sugestao->load('postador');
        return view('admin.sugestoes.show', compact('sugestao'));
    }

    public function destroy(Sugestoes $sugestao)
    {
        $sugestao->delete();
        return redirect()->route('sugestoes.index')->with('success', 'Sugestão deletada com sucesso!');
    }
}
