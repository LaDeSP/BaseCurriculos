<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Candidatura extends Model
{
	use SoftDeletes, SoftCascadeTrait; 

	protected $fillable = [
		'vagas_id', 'curriculos_id', 'status'
	];

	public function vaga(){
		return $this->belongsTo(Vaga::class, 'vagas_id');
	}

    public function curriculo(){
    	return $this->belongsTo(Curriculo::class, 'curriculos_id');
	}
	
	public function agenda(){
		return $this->hasMany(Agenda::class, 'candidatura_id');
	}
}
