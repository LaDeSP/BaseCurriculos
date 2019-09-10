<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    public function vaga(){
    	return $this->hasOne(Vaga::class,  'vagas_id');
	}
    public function curriculo(){
    	return $this->belongsTo(Curriculo::class,  'curriculos_id');
	}
}
