<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{

	protected $fillable = [
		'titulo', 'cargo', 'salario', 'beneficio', 'jornada',
		'requisito', 'juridicas_id', 'areas_id', 'quantidade', 'status', 'descricao'
	];

	public function candidatura(){
		return $this->hasMany(Candidatura::class, 'vagas_id');
	}
    public function area(){
    	return $this->belongsTo(Area::class, 'areas_id');
	}
    public function juridica(){
    	return $this->belongsTo(Juridica::class, 'juridicas_id');
	}

	public function candidaturaContratada(){
		return $this->hasMany(Candidatura::class, 'vagas_id')->where('status', 'CONTRATADO');
	}
}
