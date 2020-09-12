<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class HistoricoProfissional extends Model
{
	use SoftDeletes, SoftCascadeTrait;
	use Notifiable;

	protected $fillable = [
		'dataInicial', 'dataFinal', 'descricaoExperiencia', 'fisicas_id','curriculos_id'
    ];

    public function fisica(){
	    return $this->belongsTo(Fisica::class, 'id', 'fisicas_id');
	}
	public function curriculo(){
		return $this->belongsTo(Curriculo::class, 'id', 'curriculos_id');
	}
}
