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
    	return $this->hasOne(Fisica::class, 'id','fisicas_id');
	}
	public function candidatura(){
		return $this->belongsTo(Candidatura::class);
	}
	public function contato(){
    	return $this->hasOne(Contato::class, 'id','contatos_id');
	}
}

