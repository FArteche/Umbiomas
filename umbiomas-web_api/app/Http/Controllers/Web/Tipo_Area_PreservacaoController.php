<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tipo_Area_Preservacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Tipo_Area_PreservacaoController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipo_Area_Preservacao $tipo_Area_Preservacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipo_Area_Preservacao $tipo_Area_Preservacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo_Area_Preservacao $tipo_Area_Preservacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo_Area_Preservacao $tipo_Area_Preservacao)
    {
        //
    }

    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome_tipoap' => 'required|string|max:100|unique:tipo_area_preservacao,nome_tipoap'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $newTipo = Tipo_Area_Preservacao::create($request->all());

        return response()->json($newTipo, 201);
    }
}
