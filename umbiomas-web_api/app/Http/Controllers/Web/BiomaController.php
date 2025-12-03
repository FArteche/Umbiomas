<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bioma;
use App\Models\Caracteristica_SE;
use App\Models\Fauna;
use App\Models\Flora;
use App\Models\Clima;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class BiomaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biomas = Bioma::orderBy('nome_bioma')->get();
        return view('admin.biomas.index', compact('biomas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.biomas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome_bioma' => 'required|string|max:100|unique:biomas,nome_bioma',
            'descricao_bioma' => 'required|string',
            'populacao_bioma' => 'nullable|integer',
            'imagem_bioma' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);

        if ($request->hasFile('imagem_bioma')) {
            $path = $request->file('imagem_bioma')->store('images/biomas', 'public');

            $validatedData['imagem_bioma'] = $path;
        }

        Bioma::create($validatedData);

        return redirect()->route('biomas.index')->with('success', 'Bioma criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bioma $bioma)
    {
        return view('admin.biomas.edit', compact('bioma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bioma $bioma)
    {
        $validatedData = $request->validate([
            // A regra 'unique' é ajustada para ignorar o próprio bioma que está sendo editado
            'nome_bioma' => 'required|string|max:100|unique:biomas,nome_bioma,' . $bioma->id_bioma . ',id_bioma',
            'descricao_bioma' => 'required|string',
            'populacao_bioma' => 'nullable|integer',
            'imagem_bioma' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);
        if ($request->hasFile('imagem_bioma')) {
            if ($bioma->imagem_bioma) {
                Storage::disk('public')->delete($bioma->imagem_bioma);
            }

            $path = $request->file('imagem_bioma')->store('images/biomas', 'public');
            $validatedData['imagem_bioma'] = $path;
        }

        $bioma->update($validatedData);
        return redirect()->route('biomas.edit', $bioma)->with('success', 'Informações do bioma atualizadas!');
    }

    public function manageFauna(Request $request, Bioma $bioma)
    {
        $query = Fauna::query();
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome_fauna', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nome_cientifico_fauna', 'like', '%' . $searchTerm . '%')
                    ->orWhere('familia_fauna', 'like', '%' . $searchTerm . '%');
            });
        }

        $all_fauna = $query->orderBy('nome_fauna')->get();

        $attached_fauna_ids = $bioma->fauna->pluck('id_fauna')->toArray();
        return view('admin.biomas.manage_fauna', compact('bioma', 'all_fauna', 'attached_fauna_ids'));
    }

    public function syncFauna(Request $request, Bioma $bioma)
    {
        $bioma->fauna()->sync($request->input('fauna_ids', []));
        return redirect()->route('biomas.manageFauna', $bioma)->with('success', 'Fauna atualizada com sucesso!');
    }

    public function manageFlora(Request $request, Bioma $bioma)
    {
        $query = Flora::query();
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome_flora', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nome_cientifico_flora', 'like', '%' . $searchTerm . '%')
                    ->orWhere('familia_flora', 'like', '%' . $searchTerm . '%');
            });
        }

        $all_flora = $query->orderBy('nome_flora')->get();

        $attached_flora_ids = $bioma->flora->pluck('id_flora')->toArray();
        return view('admin.biomas.manage_flora', compact('bioma', 'all_flora', 'attached_flora_ids'));
    }

    public function syncFlora(Request $request, Bioma $bioma)
    {
        $bioma->flora()->sync($request->input('flora_ids', []));
        return redirect()->route('biomas.manageFlora', $bioma)->with('success', 'Flora atualizada com sucesso');
    }

    public function manageClima(Request $request, Bioma $bioma)
    {
        $query = Clima::query();
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome_clima', 'like', '%' . $searchTerm . '%');
            });
        }

        $all_clima = $query->orderBy('nome_clima')->get();

        $attached_clima_ids = $bioma->clima->pluck('id_clima')->toArray();
        return view('admin.biomas.manage_clima', compact('bioma', 'all_clima', 'attached_clima_ids'));
    }

    public function syncClima(Request $request, Bioma $bioma)
    {
        $bioma->clima()->sync($request->input('clima_ids', []));
        return redirect()->route('biomas.manageClima', $bioma)->with('success', 'Clima atualizado com sucesso');
    }

    public function manageCaracteristicas(Bioma $bioma)
    {
        $caracteristicas = $bioma->caracteristica_se()->with('tipocse')->get();
        return view('admin.biomas.manage_caracteristicas', compact('bioma', 'caracteristicas'));
    }

    public function manageArea_Preservacao(Bioma $bioma)
    {
        $areas = $bioma->area_preservacao()->with('tipoap')->get();
        return view('admin.biomas.manage_area_preservacao', compact('bioma', 'areas'));
    }

    public function manageRelevo(Bioma $bioma)
    {
        $relevo = $bioma->relevo()->get();
        return view('admin.biomas.manage_relevo', compact('bioma', 'relevo'));
    }

    public function manageHidrografia(Bioma $bioma)
    {
        $hidrografia = $bioma->hidrografia()->get();
        return view('admin.biomas.manage_hidrografia', compact('bioma', 'hidrografia'));
    }

    public function managePost(Bioma $bioma)
    {
        $posts = $bioma->posts()
            ->with('postador')
            ->orderByRaw('aprovado_post IS NULL DESC, created_at DESC')
            ->paginate(15);

        return view('admin.biomas.manage_post', compact('bioma', 'posts'));
    }

    public function editMap(Bioma $bioma)
    {
        return view('admin.biomas.edit_map', compact('bioma'));
    }

    public function updateMap(Request $request, Bioma $bioma)
    {
        $request->validate([
            'area_geografica' => 'nullable|json',
        ]);

        $bioma->update([
            'area_geografica' => json_decode($request->input('area_geografica'))
        ]);

        return redirect()->route('biomas.editMap', $bioma)->with('success', 'Mapa atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
