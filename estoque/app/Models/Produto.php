<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    public function fornecedores() 
    {
        return $this->belongsToMany(Fornecedor::class, 'produto_fornecedor');
    }

}
