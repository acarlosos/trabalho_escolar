<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Api extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'url',
        'usuario',
        'senha',
        'token',
    ];

    public function mercado(){
        return $this->belongsTo(Mercado::class);
    }
}
