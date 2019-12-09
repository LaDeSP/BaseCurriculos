<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Juridica extends Model
{
	use SoftDeletes, SoftCascadeTrait; 

	protected $fillable = [
		'razao', 'cnpj', 'ramo', 'missao', 
		'contatos_id', 'enderecos_id', 'user_id', 'areas_id'
	];

	protected $softCascade = ['vaga'];

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
