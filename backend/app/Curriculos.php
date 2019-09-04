<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculos extends Model
{
    public function fisicas(){
    	return $this->hasOne(\App\Fisicas::class, 'id', 'fisicas_id');
	}
}
