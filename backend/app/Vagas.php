<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    public function perfisbuscados(){
    	return $this->hasOne(\App\Perfisbuscados::class, 'id', 'perfisbuscados_id');
	}
    public function areas(){
    	return $this->hasOne(\App\Areas::class, 'id', 'areas_id');
	}
    public function juridicas(){
    	return $this->hasOne(\App\Juridicas::class, 'id', 'juridicass_id');
	}
}
