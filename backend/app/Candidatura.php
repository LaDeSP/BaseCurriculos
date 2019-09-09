<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    public function vaga(){
    	return $this->hasOne(Vaga::class, 'id', 'vagas_id');
	}
    public function curriculo(){
    	return $this->hasOne(Curriculo::class, 'id', 'curriculoss_id');
	}
}
