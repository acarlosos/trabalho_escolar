<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mercado extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'telefone',
        'rua',
        'bairro',
        'cidade',
        'cep',
        'uf',
    ];

    public function contas(){
        return $this->hasMany(Conta::class);
    }

    public function apis(){
        return $this->hasMany(Api::class);
    }
}
