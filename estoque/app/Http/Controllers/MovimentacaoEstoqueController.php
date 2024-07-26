<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoEstoque;
use App\Models\Produto;
use Illuminate\Http\Request;

class MovimentacaoEstoqueController extends Controller
{
    public function movimentaEstoque(Request $request, $codigoProduto)
    {
        $request->validate([
            'tipoMovimentacao' => 'required|string',
            'quantidade' => 'required|integer'
        ]);

        $produto = Produto::where('codigo_produto', $codigoProduto)->first();
        if(!$produto) return response()->json(['message' => 'Produto não encontrado'], 404);


        if($request->tipoMovimentacao == 'adicionar')
        {
            $produto->quantidade_produto += $request->quantidade;
        }

        if($request->tipoMovimentacao == 'remover')
        {
            if($produto->quantidade_produto < $request->quantidade)
            {
                return response()->json(['message' => 'Quantidade insuficiente no estoque'], 400);           
            }

            $produto->quantidade_produto -= $request->quantidade;
        }

        $produto->save();

        $movimentacaoEstoque = new MovimentacaoEstoque();
        $movimentacaoEstoque->produto_id = $produto->id;
        $movimentacaoEstoque->quantidade = $request->quantidade;
        $movimentacaoEstoque->tipo_movimentacao = $request->tipoMovimentacao;
        $movimentacaoEstoque->save();

        return response()->json(['message' => 'Movimentação de estoque registrada com sucesso'], 200);

    }
}
