<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProduto;
use Illuminate\Support\Facades\DB;

class TipoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra uma lista com todos os recursos cadastrados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // SELECT * FROM TIPO_PRODUTOS e armazenando o resultado no objeto $tipoProdutos
        // Esse objeto é um vetor de models
        //$tipoProdutos = TipoProduto::all();
        $tipoProdutos = DB::select('SELECT * FROM TIPO_PRODUTOS');
        //print_r($tipoProdutos);
        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos);
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar um formulário para criação de um novo recurso
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("TipoProduto/create");
    }

    /**
     * Store a newly created resource in storage.
     * Armazena um recurso recém criado na base de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoProduto = new TipoProduto();
        $tipoProduto->descricao = $request->descricao;
        $tipoProduto->save();
        return $this->index();
    }

    /**
     * Display the specified resource.
     * Mostra um recurso específico em detalhes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoProdutos = DB::select('SELECT id, descricao, updated_at, created_at FROM tipo_produtos WHERE id = ?', [$id]);

        if (count($tipoProdutos) > 0)
            return view("tipoproduto.show")->with("tipoProduto", $tipoProdutos[0]);

        echo "TipoProduto não encontrado.";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoProduto = TipoProduto::find($id);

        if (isset($tipoProduto)) {
            return view("tipoproduto.edit")->with("tipoProduto", $tipoProduto);
        }

        echo "TipoProduto não encontrado";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoProduto = TipoProduto::find($id);

        if (isset($tipoProduto)) {
            $tipoProduto->descricao = $request->descricao;
            $tipoProduto->update();

            return $this->index();
        }

        echo "Produto não encontrado";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoProduto = TipoProduto::find($id);

        if (isset($tipoProduto)) {
            $tipoProduto->delete();
            return \Redirect::route('tipoproduto.index');
        } else {
            echo "Produto não encontrado";
        }
    }
}
