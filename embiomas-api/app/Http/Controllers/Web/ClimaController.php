<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Clima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClimaController extends Controller
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
        $returnTo = $request->query('return_to', route('biomas.index'));

        return view('admin.clima.create', compact('returnTo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_clima' => 'required|string|max:50',
            'descricao_clima' => 'required|string',
            'imagem_clima' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);

        if ($request->hasFile('imagem_clima')) {
            $path = $request->file('imagem_clima')->store('images/climas', 'public');

            $validatedData['imagem_clima'] = $path;
        }

        Clima::create($validatedData);

        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Novo clima adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clima $clima)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Clima $clima)
    {
        $returnTo = $request->query('return_to');
        return view('admin.clima.edit', compact('clima', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clima $clima)
    {
        $validatedData = $request->validate([
            'nome_clima' => 'required|string|max:50',
            'descricao_clima' => 'required|string',
            'imagem_clima' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);

        if ($request->hasFile('imagem_clima')) {
            if ($clima->imagem_clima) {
                Storage::disk('public')->delete($clima->imagem_clima);
            }

            $path = $request->file('imagem_clima')->store('images/climas', 'public');
            $validatedData['imagem_clima'] = $path;
        }

        $clima->update($validatedData);
        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Clima editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clima $clima)
    {

        $clima->delete();

        return back()->with('success', 'Clima deletado com sucesso!');
    }
}
