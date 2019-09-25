<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fisica extends Model
{
	protected $fillable = [
		'cpf', 'genero', 'estado_civil', 'data_nascimento', 
		'contatos_id', 'enderecos_id', 'user_id'
	];

	public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
	}

    public function contato(){
    	return $this->hasOne(Contato::class,  'id', 'contatos_id');
	}
	
    public function endereco(){
    	return $this->hasOne(Endereco::class, 'id', 'enderecos_id');
	}

	public function curriculo(){
		return $this->hasOne(Curriculo::class);
	}
	
}
