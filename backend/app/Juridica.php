<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juridica extends Model
{
	public function user(){
    	return $this->belongsTo(User::class,  'user_id');
	}
    public function contato(){
    	return $this->belongsTo(Contato::class, 'contatos_id');
	}
    public function endereco(){
    	return $this->belongsTo(Endereco::class,  'enderecos_id');
	}
	public function vagas(){
    	return $this->hasMany(Vaga::class);
	}

}
