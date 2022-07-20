<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    public function __construct(Cidade $cidade)
    {   
        $this->cidade = $cidade; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidade = $this->cidade->all();
        return response()->json($cidade, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cidade = $this->cidade->create($request->all());
        return $cidade;
    }


    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cidade = $this->cidade->with('produtos')->find($id);
        return $cidade;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cidade = $this->cidade->find($id);
        $cidade->update($request->all());
        return $cidade;
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //O delete não vai ocorrer se a id estiver associada á um produto
        $cidade = $this->cidade->find($id);
        $cidade->delete();
        return ['msg' => 'Cidade excluida!'];
    }
    
}
