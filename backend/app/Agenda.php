<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
		'data', 'hora', 'observacao', 'contraproposta', 'candidatura_id'
	];

	public function candidatura(){
		return $this->hasOne(Candidatura::class, 'candidatura_id');
	}
}
