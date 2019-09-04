<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juridicas extends Model
{
    public function contatos(){
    	return $this->hasOne(\App\Contatos::class, 'id', 'contatos_id');
	}
    public function enderecos(){
    	return $this->hasOne(\App\Enderecos::class, 'id', 'enderecos_id');
	}
}
