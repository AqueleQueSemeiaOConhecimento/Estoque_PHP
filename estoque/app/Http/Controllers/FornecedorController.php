<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Produto;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function cadastrarFornecedor(Request $request)
    {
        $request->validate([
            'nomeFornecedor' => 'required|string'
        ]);

        $fornecedor = new Fornecedor();
        $fornecedor->nome_fornecedor = $request->input('nomeFornecedor');
      
        $fornecedor->save();

        return response()->json(['message' => 'Fornecedor cadastrado com sucesso']);
    }

    public function atualizarFornecedor(Request $request, $externoId)
    {
        $fornecedor = Fornecedor::where('id', $externoId)->first();
        if(!$fornecedor) return response()->json(['message' => 'Fornecedor não encontrado'], 404);

        $request->validate([
            'nomeFornecedor' => 'required|string'
        ]);

        $fornecedor->nome_fornecedor = $request->input('nomeFornecedor');
        $fornecedor->save();

        return response()->json(['message' => 'Fornecedor atualizado com sucesso'], 200);
    }

    public function vincularFornecedor(Request $request, $codigoProduto, $idFornecedor)
    {
        $produto = Produto::where('codigo_produto', $codigoProduto)->first();
        if(!$produto) return response()->json(['message' => 'Produto não encontrado'], 404);

        $fornecedor = Fornecedor::find($idFornecedor);
        if(!$fornecedor) return response()->json(['message' => 'Fornecedor não encontrado'], 404);

        $produto->fornecedores()->attach($fornecedor->id);
        return response()->json(['message' => 'Fornecedor vinculado com sucesso com o produto'], 200);
    }

    public function desvincularFornecedor(Request $request, $codigoProduto, $idFornecedor)
    {
        $produto = Produto::where('codigo_produto', $codigoProduto)->first();
        if(!$produto) return response()->json(['message' => 'Produto não encontrado'], 404);

        $fornecedor = Fornecedor::find($idFornecedor);
        if(!$fornecedor) return response()->json(['message' => 'Fornecedor não encontrado'], 404);

        $produto->fornecedores()->detach($fornecedor->id);
        return response()->json(['message' => 'Fornecedor desvinculado com sucesso do produto'], 200);
    }
}
