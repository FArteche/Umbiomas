<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Hidrografia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HidrografiaController extends Controller
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
        return view('admin.hidrografia.create', compact('bioma_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_hidrografia' => 'required|string|max:100',
            'descricao_hidrografia' => 'required|string',
            'tipo_hidrografia' => 'required|string|max:100',
            'imagem_hidrografia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
            'bioma_id' => 'required|exists:biomas,id_bioma',
        ]);

        if ($request->hasFile('imagem_hidrografia')) {
            $path = $request->file('imagem_hidrografia')->store('images/hidrografia', 'public');
            $validatedData['imagem_hidrografia'] = $path;
        }

        hidrografia::create($validatedData);

        // Redireciona de volta para a página de gerenciamento daquele bioma
        return redirect()->route('biomas.manageHidrografia', ['bioma' => $request->bioma_id])
            ->with('success', 'hidrografia criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(hidrografia $hidrografia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, hidrografia $hidrografia)
    {
        $returnTo = $request->query('return_to', route('biomas.index'));

        return view('admin.hidrografia.edit', compact('hidrografia', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, hidrografia $hidrografia)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_hidrografia' => 'required|string|max:100',
            'descricao_hidrografia' => 'required|string',
            'tipo_hidrografia' => 'required|string|max:100',
            'imagem_hidrografia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);

        // 2. Lógica para atualizar a imagem (se houver)
        if ($request->hasFile('imagem_hidrografia')) {
            if ($hidrografia->imagem_hidrografia) {
                Storage::disk('public')->delete($hidrografia->imagem_hidrografia);
            }
            $path = $request->file('imagem_hidrografia')->store('images/hidrografia', 'public');
            $validatedData['imagem_hidrografia'] = $path;
        }

        // 3. CORRETO: use o método update() no objeto $hidrografia existente
        $hidrografia->update($validatedData);

        // 4. Redirecione de volta com a mensagem de sucesso
        return redirect()->route('biomas.manageHidrografia', $hidrografia->bioma_id)->with('success', 'hidrografia atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hidrografia $hidrografia)
    {
        if ($hidrografia->imagem_hidrografia) {
            Storage::disk('public')->delete($hidrografia->imagem_hidrografia);
        }

        $hidrografia->delete();

        return back()->with('success', 'hidrografia deletado com sucesso!');
    }
}
