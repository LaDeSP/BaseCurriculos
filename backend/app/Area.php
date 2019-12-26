<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'tipo'
    ];

    public function vagas(){
        return $this->hasMany(Vaga::class);
    }
    
    public function curriculo(){
        return $this->hasMany(Curriculo::class);
    }
}
