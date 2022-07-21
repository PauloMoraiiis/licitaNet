<?php

namespace App\Http\Controllers;

use App\Models\Produto;
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
    public function index(Request $request)
    {
        $produtos = array();

        if($request->has('atributos_cidade')) {
            $atributos_cidade = $request->atributos_cidade;
            $produtos = $this->produto->with('cidade:id,'.$atributos_cidade);
        } else {
            $produtos = $this->produto->with('cidade');
        }

        if($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach($filtros as $key => $condicao) {

                $c = explode(':', $condicao);
                $produtos = $produtos->where($c[0], $c[1], $c[2]);

            }
        }

        if($request->has('atributos')) {
            $atributos = $request->atributos;
            $produtos = $produtos->selectRaw($atributos)->get();
        } else {
            $produtos = $produtos->paginate(9);
        }

        //$this->modelo->with('marca')->get()
        return response()->json($produtos, 200);
        //all() -> criando um obj de consulta + get() = collection
        //get() -> modificar a consulta -> collection
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
        //Localiza o produto pelo id e adiciona a cidade (belongsTo em Model/Produto)
        $produto = $this->produto->with('cidade')->find($id);  

        //Se o produto não for localizado retorna a mensagem 
        if($produto === null) {
            return response()->json(['errors' => 'Produto não localizado'], 404);
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
            return response()->json(['errors' => 'Alteração não foi realizada, produto não localizado'], 404); //Retorna mensagem de erro
        }


        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($produto->rules() as $input => $regra) {
                
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            //Realiza a validação com as regras do model
            $request->validate($regrasDinamicas, $produto->feedback());

            //preenchendo o objeto $marca com todos os dados do request
            $produto->fill($request->all());

        } else {
            $request->validate($produto->rules(), $produto->feedback());
        }



        
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
            return Response()->json(['errors' => 'Impossivel realizar a exclusão, produto não localizado'], 404);
        }
        
        $produto->delete(); //Realiza a exclusão do produto
        return response()->json(['msg' => 'Produto excluido!'], 200); //Retorna mensagem em json
    }
}
