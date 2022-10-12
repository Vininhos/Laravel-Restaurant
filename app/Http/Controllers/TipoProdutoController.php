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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMessage($message)
    {
        try {
            $tipoProdutos = DB::select('SELECT * FROM TIPO_PRODUTOS');
        } catch (\Throwable $th) {
            return view("TipoProduto/index")->with("tipoProdutos", [])->with("message", [$th->getMessage(), "danger"]);
        }

        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos)->with("message", $message);
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar um formulário para criação de um novo recurso
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view("TipoProduto/create");
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
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
        try {
            $tipoProduto = new TipoProduto();
            $tipoProduto->descricao = $request->descricao;
            $tipoProduto->save();
            return $this->index();
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }

        return $this->indexMessage(["TipoProduto cadastrado com sucesso", "success"]);
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
        try {
            $tipoProdutos = DB::select('SELECT id, descricao, updated_at, created_at FROM tipo_produtos WHERE id = ?', [$id]);

            if (count($tipoProdutos) > 0)
                return view("tipoproduto.show")->with("tipoProduto", $tipoProdutos[0]);

            return $this->indexMessage(["TipoProduto não encontrado", "warning"]);
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $tipoProduto = TipoProduto::find($id);

            if (isset($tipoProduto)) {
                return view("tipoproduto.edit")->with("tipoProduto", $tipoProduto);
            }

            return $this->indexMessage(["Produto não encontrado", "warning"]);
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
        $tipoProduto = TipoProduto::find($id);
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
        try {
            $tipoproduto = tipoproduto::find($id);

            if (isset($tipoproduto)) {
                $tipoproduto->descricao = $request->descricao;
                $tipoproduto->update();

                return $this->index();
            }
            return $this->indexMessage(["TipoProduto não encontrado", "warning"]);
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tipoproduto = tipoproduto::find($id);

            if (isset($tipoproduto)) {
                $tipoproduto->delete();

                return $this->indexMessage(["Produto removido com sucesso", "success"]);
            } else {
                return $this->indexMessage(["TipoProduto não encontrado", "warning"]);
            }
        } catch (\Throwable $th) {
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
    }
}
