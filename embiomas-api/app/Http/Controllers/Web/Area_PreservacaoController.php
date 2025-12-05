<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area_Preservacao;
use App\Models\Tipo_Area_Preservacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Area_PreservacaoController extends Controller
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
        $tipos = Tipo_Area_Preservacao::orderBy('nome_tipoap')->get();

        // Pega o bioma_id que veio da URL
        $bioma_id = $request->query('bioma_id');

        // Se não houver bioma_id, é um erro. Voltamos com uma mensagem.
        if (!$bioma_id) {
            return redirect()->back()->with('error', 'É necessário especificar um bioma.');
        }

        // Passa o bioma_id para a view
        return view('admin.areapreservacao.create', compact('tipos', 'bioma_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Adiciona bioma_id na validação
        $validatedData = $request->validate([
            'nome_ap' => 'required|string|max:100',
            'descricao_ap' => 'required|string',
            'imagem_ap' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'tipoap_id' => 'required|exists:tipo_area_preservacao,id_tipoap',
            'bioma_id' => 'required|exists:biomas,id_bioma',
        ]);

        if ($request->hasFile('imagem_ap')) {
            $path = $request->file('imagem_ap')->store('images/areapreservacao', 'public');

            $validatedData['imagem_ap'] = $path;
        }

        Area_Preservacao::create($validatedData);

        // Redireciona de volta para a página de gerenciamento daquele bioma
        return redirect()->route('biomas.manageArea_Preservacao', ['bioma' => $request->bioma_id])
            ->with('success', 'Área de preservacao criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area_Preservacao $area_Preservacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Area_Preservacao $area_preservacao)
    {
        $returnTo = $request->query('return_to', route('biomas.index'));

        $tipos = Tipo_Area_Preservacao::orderBy('nome_tipoap')->get();

        // Passa o bioma_id para a view
        return view('admin.areapreservacao.edit', compact('tipos', 'area_preservacao', 'returnTo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area_Preservacao $area_preservacao)
    {
        $validatedData = $request->validate([
            'nome_ap' => 'required|string|max:100',
            'descricao_ap' => 'required|string',
            'imagem_ap' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'tipoap_id' => 'required|exists:tipo_area_preservacao,id_tipoap'
        ]);

        if ($request->hasFile('imagem_ap')) {
            if ($area_preservacao->imagem_ap) {
                Storage::disk('public')->delete($area_preservacao->imagem_ap);
            }

            $path = $request->file('imagem_ap')->store('images/areapreservacao', 'public');
            $validatedData['imagem_ap'] = $path;
        }

        $area_preservacao->update($validatedData);

        $redirectUrl = $request->input('return_to', route('biomas.index'));

        return redirect($redirectUrl)->with('success', 'Area de preservação editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area_Preservacao $area_preservacao)
    {
        $area_preservacao->delete();

        return back()->with('success', 'Area de preservação deletada com sucesso!');
    }

    public function editMap(Area_Preservacao $area_preservacao)
    {
        return view('admin.areapreservacao.edit_map', ['area' => $area_preservacao]);
    }

    public function updateMap(Request $request, Area_Preservacao $area_preservacao)
    {
        $validated = $request->validate(['area_geografica' => 'nullable|json']);

        $areaGeograficaArray = $validated['area_geografica']
            ? json_decode($validated['area_geografica'], true)
            : null;

        $area_preservacao->update([
            'area_geografica' => $areaGeograficaArray
        ]);

        return redirect()->route('areas-preservacao.editMap', $area_preservacao)->with('success', 'Mapa atualizado com sucesso!');
    }
}
