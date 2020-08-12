<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoricoProfissional extends Model
{

	protected $fillable = [
		'data_inicial', 'data_final', 'descricao_experiencia'
    ];
    
    public function curriculo(){
	    return $this->belongsTo(Curriculo::class, 'id', 'historicosP_id');
	}
}
