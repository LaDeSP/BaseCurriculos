<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Curriculo extends Model
{
	use SoftDeletes, SoftCascadeTrait; 

    protected $softCascade = ['candidatura', 'convite'];

	protected $fillable = [
		'objetivos', 'areas_id', 'pretensao', 'qualificacoes', 
		'escolaridade', 'historicoProfissional', 'fisicas_id'
	];
	
    public function fisica(){
    	return $this->hasOne(Fisica::class, 'id','fisicas_id');
	}

	public function candidatura(){
		return $this->hasMany(Candidatura::class, 'curriculos_id');
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

