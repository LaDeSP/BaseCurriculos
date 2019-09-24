<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
	protected $fillable = [
		'vagas_id', 'curriculos_id'
	];

    public function vaga(){
    	return $this->belongsTo(Vaga::class);
	}
    public function curriculo(){
    	return $this->hasOne(Curriculo::class, 'id', 'curriculos_id');
	}
}
