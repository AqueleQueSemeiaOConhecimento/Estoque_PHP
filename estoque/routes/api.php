<?php

use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// PRODUTO

Route::post('/adicionar/produto', [ProdutoController::class, 'adicionarProduto']);

Route::put('/atualizar/produto/{codigo}', [ProdutoController::class, 'atualizarProduto']);

// FORNECEDOR

Route::post('/cadastrar/fornecedor', [FornecedorController::class, 'cadastrarFornecedor']);

Route::put('/atualizar/fornecedor/{id}', [FornecedorController::class, 'atualizarFornecedor']);

Route::post('/vincular/fornecedor/{codigoProduto}/{idFornecedor}', [FornecedorController::class, 'vincularFornecedor']);

Route::put('/desvincular/fornecedor/{codigoProduto}/{idFornecedor}', [FornecedorController::class, 'desvincularFornecedor']);

// MOVIMENTA ESTOQUE

Route::post('/movimenta/estoque/{codigoProduto}', [MovimentacaoEstoqueController::class, 'movimentaEstoque']);