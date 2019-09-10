<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'cep', 'rua', 'bairro', 'numero', 'complemento', 'cidade',
        'estado', 'pais'
    ];
    
    public function fisica(){
        return $this->hasOne(Fisica::class);
    }

    public function juridica(){
        return $this->hasOne(Juridica::class);
    }
}
