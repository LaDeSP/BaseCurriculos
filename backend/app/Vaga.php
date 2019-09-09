<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    public function perfilBuscado(){
    	return $this->hasOne(PerfilBuscado::class, 'id', 'perfisbuscados_id');
	}
    public function area(){
    	return $this->hasOne(Area::class, 'id', 'areas_id');
	}
    public function juridica(){
    	return $this->hasOne(Juridica::class, 'id', 'juridicas_id');
	}
}
