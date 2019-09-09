<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fisica extends Model
{
	protected $fillable = [
        'nascimento', 'genero', 'estadocivil', 'contatos_id', 'enderecos_id'
	];

	public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
	}

    public function contato(){
    	return $this->hasOne(Contato::class, 'id', 'contatos_id');
	}
    public function endereco(){
    	return $this->hasOne(Endereco::class, 'id', 'enderecos_id');
	}
}
