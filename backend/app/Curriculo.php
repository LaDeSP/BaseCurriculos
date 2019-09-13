<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
	protected $fillable = [
		'objetivos', 'area', 'pretensao', 'qualificacoes', 
		'escolaridade', 'historicoProfissional', 'fisicas_id'
	];
	
    public function fisica(){
    	return $this->belongsTo(Fisica::class, 'fisicas_id');
	}
}

