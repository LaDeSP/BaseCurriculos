<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait; 

class Convite extends Model
{
    use SoftDeletes, SoftCascadeTrait; 

    protected $fillable = [
        'resposta', 'curriculos_id', 'vagas_id'
    ];
    public function vaga(){
		return $this->belongsTo(Vaga::class, 'vagas_id');
    }
    public function curriculo(){
    	return $this->hasOne(Curriculo::class, 'id', 'curriculos_id');
	}

}
