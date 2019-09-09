<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
	protected $fillable = [
        'objetivos', 'area', 'pretensao', 'qualificacoes', 'escolaridade'
	];
	
    public function fisica(){
    	return $this->hasOne(Fisica::class, 'id', 'fisicas_id');
	}
}

