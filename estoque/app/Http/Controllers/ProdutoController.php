<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProdutoController extends Controller
{
    public function adicionarProduto(Request $request)
    {
        $request->validate([
            'nomeProduto' => 'required|string',
            'marcaProduto' => 'required|string',
            'precoProduto' => 'required|numeric',
            'quantidadeProduto' => 'required|integer',
            'codigoProduto' => 'required|string',
            'idFornecedor' => 'required|integer'
        ]);

        $produto = new Produto();
        $produto->nome_produto = $request->input('nomeProduto');
        $produto->nome_marca = $request->input('marcaProduto');
        $produto->preco_produto = $request->input('precoProduto');
        $produto->quantidade_produto = $request->input('quantidadeProduto');
        $produto->codigo_produto = $request->input('codigoProduto');
        $produto->save();

        $fornecedor = Fornecedor::find($request->idFornecedor);
        if(!$fornecedor) return response()->json(['message' => 'Fornecedor não encontrado'], 404);

        $produto->fornecedores()->attach($fornecedor->id);
        return response()->json(['message' => 'Produto cadastrado com sucesso e vinculado com fornecedor com sucesso'], 200);

    }

    public function atualizarProduto(Request $request, $externoCodigo)
    {
        $produto = Produto::where('codigo_produto', $externoCodigo)->first();

        if(!$produto) return response()->json(['message' => 'produto não registrado na base de dados']);

        $request->validate([
            'nomeProduto' => 'required|string',
            'marcaProduto' => 'required|string',
            'precoProduto' => 'required|numeric',
            'quantidadeProduto' => 'required|integer'
        ]);

        $produto->nome_produto = $request->input('nomeProduto');
        $produto->nome_marca = $request->input('marcaProduto');
        $produto->preco_produto = $request->input('precoProduto');
        $produto->quantidade_produto = $request->input('quantidadeProduto');
        $produto->save();

        return response()->json(['message' => 'produto atualizado com sucesso']);

        
    }
}
