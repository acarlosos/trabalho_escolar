<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conta extends Model
{
    use SoftDeletes;
    protected $fillable =[
        'banco',
        'agencia',
        'conta',
        'principal',
    ];
    
    protected $casts = [
        'principal' => 'bollean'
    ];

    public function mercado(){
        return $this->belongsTo(Mercado::class);
    }
}
