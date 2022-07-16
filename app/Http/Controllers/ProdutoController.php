<?php

namespace App\Http\Controllers;

use App\Models\produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function __construct(produto $produto)
    {   
        $this->produto = $produto; //Instancia o model produto dentro ma variavel $produto
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Retorna todos os produtos em um json
        $produto = $this->produto->all();
        return response()->json($produto, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->produto->rules(), $this->produto->feedback()); //Realiza a validação de acordo com as funções rules e feedback em Model/produto 
        $produto = $this->produto->create($request->all()); //Salva o produto no banco de dados
        return response()->json($produto, 201); //Retorna um array do produto criado no formato json
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->find($id); //Salva o produto referente ao id informado em $produto

        //Se o produto não for localizado retorna um json 
        if($produto === null) {
            return response()->json(['msg' => 'Produto não localizado'], 404);
        }

        return response()->json($produto, 200); //Retorna o produto em um json
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produto = $this->produto->find($id); //Salva o produto referente ao id informado em $produto

        //Se o produto não for localizado retorna um json
        if($produto === null) {
            return response()->json(['erro' => 'Alteração não foi realizada'], 404); //Retorna mensagem de erro
        }

        $request->validate($produto->rules(), $produto->feedback()); //Realiza a validação de acordo com as funções rules e feedback em Model/produto 
        $produto->update($request->all()); //Atualiza o produto na tabela
        return response()->json($produto, 200); //Retorna o produto atualizado em json
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = $this->produto->find($id); //Salva o produto referente ao id informado em $produto
        //Se o produto não for localizado retorna um json
        if($produto === null) {
            return Response()->json(['msg' => 'Impossivel realizar a exclusão, produto não localizado'], 404);
        }
        
        $produto->delete(); //Realiza a exclusão do produto
        return response()->json(['msg' => 'Produto excluido!'], 200); //Retorna mensagem em json
    }
}
