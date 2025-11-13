<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Flora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FloraController extends Controller
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

        return view('admin.flora.create', compact('returnTo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_flora' => 'required|string|max:50|unique:flora,nome_flora',
            'nome_cientifico_flora' => 'nullable|string|max:100',
            'familia_flora' => 'nullable|string|max:100',
            'descricao_flora' => 'nullable|string',
            'imagem_flora' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);

        if ($request->hasFile('imagem_flora')) {
            $path = $request->file('imagem_flora')->store('images/flora', 'public');
            $validatedData['imagem_flora'] = $path;
        }

        flora::create($validatedData);

        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Nova planta adicionado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(flora $flora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, flora $flora)
    {
        $returnTo = $request->query('return_to');
        return view('admin.flora.edit', compact('flora', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, flora $flora)
    {
        $validatedData = $request->validate([
            'nome_flora' => 'required|string|max:50',
            'nome_cientifico_flora' => 'nullable|string|max:100',
            'familia_flora' => 'nullable|string|max:100',
            'descricao_flora' => 'nullable|string',
            'imagem_flora' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
        ]);
        if ($request->hasFile('imagem_flora')) {
            if ($flora->imagem_flora) {
                Storage::disk('public')->delete($flora->imagem_flora);
            }

            $path = $request->file('imagem_flora')->store('images/flora', 'public');
            $validatedData['imagem_flora'] = $path;
        }

        $flora->update($validatedData);
        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Planta editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(flora $flora)
    {
        if ($flora->imagem_flora) {
            Storage::disk('public')->delete($flora->imagem_flora);
        }

        $flora->delete();

        return back()->with('success', 'Planta deletado com sucesso!');
    }
}
