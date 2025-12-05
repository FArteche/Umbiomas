<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Relevo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RelevoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Pega o bioma_id que veio da URL
        $bioma_id = $request->query('bioma_id');

        // Se não houver bioma_id, é um erro. Voltamos com uma mensagem.
        if (!$bioma_id) {
            return redirect()->back()->with('error', 'É necessário especificar um bioma.');
        }

        // Passa o bioma_id para a view
        return view('admin.relevo.create', compact('bioma_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_relevo' => 'required|string|max:100',
            'descricao_relevo' => 'required|string',
            'tipo_relevo' => 'required|string|max:100',
            'imagem_relevo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
            'bioma_id' => 'required|exists:biomas,id_bioma',
        ]);

        if ($request->hasFile('imagem_relevo')) {
            $path = $request->file('imagem_relevo')->store('images/relevo', 'public');
            $validatedData['imagem_relevo'] = $path;
        }

        Relevo::create($validatedData);

        // Redireciona de volta para a página de gerenciamento daquele bioma
        return redirect()->route('biomas.manageRelevo', ['bioma' => $request->bioma_id])
            ->with('success', 'Relevo criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Relevo $relevo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Relevo $relevo)
    {
        $returnTo = $request->query('return_to', route('biomas.index'));

        return view('admin.relevo.edit', compact('relevo', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Relevo $relevo)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_relevo' => 'required|string|max:100',
            'descricao_relevo' => 'required|string',
            'tipo_relevo' => 'required|string|max:100',
            'imagem_relevo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);

        // 2. Lógica para atualizar a imagem (se houver)
        if ($request->hasFile('imagem_relevo')) {
            if ($relevo->imagem_relevo) {
                Storage::disk('public')->delete($relevo->imagem_relevo);
            }
            $path = $request->file('imagem_relevo')->store('images/relevo', 'public');
            $validatedData['imagem_relevo'] = $path;
        }

        // 3. CORRETO: use o método update() no objeto $relevo existente
        $relevo->update($validatedData);

        // 4. Redirecione de volta com a mensagem de sucesso
        return redirect()->route('biomas.manageRelevo', $relevo->bioma_id)->with('success', 'Relevo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Relevo $relevo)
    {
        if ($relevo->imagem_relevo) {
            Storage::disk('public')->delete($relevo->imagem_relevo);
        }

        $relevo->delete();

        return back()->with('success', 'Relevo deletado com sucesso!');
    }
}
