<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Caracteristica_SE;
use App\Models\Tipo_CSE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Caracteristica_SEController extends Controller
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
        $tipos = Tipo_CSE::orderBy('nome_tipocse')->get();

        // Pega o bioma_id que veio da URL
        $bioma_id = $request->query('bioma_id');

        // Se não houver bioma_id, é um erro. Voltamos com uma mensagem.
        if (!$bioma_id) {
            return redirect()->back()->with('error', 'É necessário especificar um bioma.');
        }

        // Passa o bioma_id para a view
        return view('admin.caracteristicas.create', compact('tipos', 'bioma_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_cse' => 'required|string|max:100',
            'descricao_cse' => 'required|string',
            'imagem_cse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'tipocse_id' => 'required|exists:tipo_cse,id_tipocse',
            'bioma_id' => 'required|exists:biomas,id_bioma',
        ]);
        if ($request->hasFile('imagem_ cse')) {
            $path = $request->file('imagem_cse')->store('images/cse', 'public');

            $validatedData['imagem_cse'] = $path;
        }
        Caracteristica_SE::create($validatedData);

        // Redireciona de volta para a página de gerenciamento daquele bioma
        return redirect()->route('biomas.manageCaracteristicas', ['bioma' => $request->bioma_id])
            ->with('success', 'Característica criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Caracteristica_SE $caracteristica_SE)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Caracteristica_SE $caracteristica_se)
    {
        $returnTo = $request->query('return_to', route('biomas.index'));

        $tipos = Tipo_CSE::orderBy('nome_tipocse')->get();

        // Passa o bioma_id para a view
        return view('admin.caracteristicas.edit', compact('tipos', 'caracteristica_se', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Caracteristica_SE $caracteristica_se)
    {
        $validatedData = $request->validate([
            'nome_cse' => 'required|string|max:100',
            'descricao_cse' => 'required|string',
            'imagem_cse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'tipocse_id' => 'required|exists:tipo_cse,id_tipocse'
        ]);
        if ($request->hasFile('imagem_cse')) {
            if ($caracteristica_se->imagem_cse) {
                Storage::disk('public')->delete($caracteristica_se->imagem_cse);
            }

            $path = $request->file('imagem_cse')->store('images/cse', 'public');
            $validatedData['imagem_cse'] = $path;
        }
        $caracteristica_se->update($validatedData);

        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Caracteristica editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caracteristica_SE $caracteristica_se)
    {
        $caracteristica_se->delete();

        return back()->with('success', 'Característica deletada com sucesso!');
    }
}
