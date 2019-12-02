<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
	protected $fillable = [
		'objetivos', 'areas_id', 'pretensao', 'qualificacoes', 
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
	public function area(){
    	return $this->belongsTo(Area::class, 'areas_id');
	}
	public function convite(){
		return $this->belongsTo(Convite::class);
	}
}

