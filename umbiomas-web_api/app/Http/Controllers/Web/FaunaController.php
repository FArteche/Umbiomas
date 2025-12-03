<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Fauna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaunaController extends Controller
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

        return view('admin.fauna.create', compact('returnTo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_fauna' => 'required|string|max:50|unique:fauna,nome_fauna',
            'nome_cientifico_fauna' => 'nullable|string|max:100',
            'familia_fauna' => 'nullable|string|max:100',
            'descricao_fauna' => 'nullable|string',
            'imagem_fauna' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);

        if ($request->hasFile('imagem_fauna')) {
            $path = $request->file('imagem_fauna')->store('images/fauna', 'public');
            $validatedData['imagem_fauna'] = $path;
        }

        Fauna::create($validatedData);

        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Novo animal adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fauna $fauna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Fauna $fauna)
    {
        $returnTo = $request->query('return_to');
        return view('admin.fauna.edit', compact('fauna', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fauna $fauna)
    {
        $validatedData = $request->validate([
            'nome_fauna' => 'required|string|max:50',
            'nome_cientifico_fauna' => 'nullable|string|max:100',
            'familia_fauna' => 'nullable|string|max:100',
            'descricao_fauna' => 'nullable|string',
            'imagem_fauna' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);
        if ($request->hasFile('imagem_fauna')) {
            if ($fauna->imagem_fauna) {
                Storage::disk('public')->delete($fauna->imagem_fauna);
            }

            $path = $request->file('imagem_fauna')->store('images/fauna', 'public');
            $validatedData['imagem_fauna'] = $path;
        }

        $fauna->update($validatedData);
        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Animal editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fauna $fauna)
    {
        if ($fauna->imagem_fauna) {
            Storage::disk('public')->delete($fauna->imagem_fauna);
        }

        $fauna->delete();

        return back()->with('success', 'Animal deletado com sucesso!');
    }
}
