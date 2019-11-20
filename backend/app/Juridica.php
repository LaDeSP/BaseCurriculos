<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juridica extends Model
{
	protected $fillable = [
		'razao', 'cnpj', 'ramo', 'missao', 
		'contatos_id', 'enderecos_id', 'user_id', 'areas_id'
	];

	public function user(){
    	return $this->belongsTo(User::class,  'user_id');
	}
    public function contato(){
    	return $this->hasOne(Contato::class,  'id', 'contatos_id');
	}
    public function endereco(){
    	return $this->hasOne(Endereco::class, 'id', 'enderecos_id');
	}
	public function vaga(){
    	return $this->hasMany(Vaga::class, 'juridicas_id', 'id');
	}

}
