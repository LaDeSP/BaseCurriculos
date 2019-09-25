<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
		'data', 'hora', 'observacao', 'candidatura_id'
	];
}
