<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
	protected $fillable = [
		'vagas_id', 'curriculos_id'
	];

    public function vaga(){
    	return $this->belongsTo(Vaga::class, 'vagas_id');
	}
    public function curriculo(){
    	return $this->belongsTo(Curriculo::class, 'curriculos_id');
	}
}
