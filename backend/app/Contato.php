<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'emailAlt', 'linkedin', 'facebook', 'twitter', 'site', 'outraRede', 'fixo', 'celular'
    ];
    
    public function fisica(){
        return $this->belongsTo(Fisica::class);
    }

    public function juridica(){
        return $this->belongsTo(Juridica::class);
    }
    public function curriculo(){
		return $this->belongsTo(Curriculo::class);
	}
}
