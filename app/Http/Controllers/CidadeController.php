<?php

namespace App\Http\Controllers;

use App\Models\cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidade = Cidade::all();
        return $cidade;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cidade = Cidade::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cidade  $cidade
     * @return \Illuminate\Http\Response
     */
    public function show(cidade $cidade)
    {
        return $cidade;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cidade  $cidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cidade $cidade)
    {
        $cidade->update($request->all());
        return $cidade;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cidade  $cidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(cidade $cidade)
    {
        //
    }
}
