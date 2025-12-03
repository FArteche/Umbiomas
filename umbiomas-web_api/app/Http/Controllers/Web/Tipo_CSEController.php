<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tipo_CSE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Tipo_CSEController extends Controller
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
    public function show(Tipo_CSE $tipo_CSE)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipo_CSE $tipo_CSE)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo_CSE $tipo_CSE)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo_CSE $tipo_CSE)
    {
        //
    }

    public function storeAjax(Request $request){
        $validator = Validator::make($request->all(), [
            'nome_tipocse' => 'required|string|max:100|unique:tipo_cse,nome_tipocse'
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()->first()],422);
        }

        $newTipo = Tipo_CSE::create($request->all());

        return response()->json($newTipo, 201);
    }
}
