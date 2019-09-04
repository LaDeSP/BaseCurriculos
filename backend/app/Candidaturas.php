<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidaturas extends Model
{
    public function vagas(){
    	return $this->hasOne(\App\Vagas::class, 'id', 'vagas_id');
	}
    public function curriculos(){
    	return $this->hasOne(\App\Curriculos::class, 'id', 'curriculoss_id');
	}
}
