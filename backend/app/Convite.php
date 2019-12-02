<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convite extends Model
{
    protected $fillable = [
        'resposta', 'curriculos_id', 'vagas_id'
    ];
    public function vaga(){
		return $this->belongsTo(Vaga::class, 'vagas_id');
    }
    public function curriculo(){
    	return $this->hasOne(Curriculo::class, 'id', 'curriculos_id');
	}

}
