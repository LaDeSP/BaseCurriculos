<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoProfissional extends Model
{

	protected $fillable = [
		'dataInicial', 'dataFinal', 'descricaoExperiencia', 'fisicas_id'
    ];
    
    public function fisica(){
	    return $this->belongsTo(Fisica::class, 'id', 'fisicas_id');
	}
}
