<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'emailAlt', 'linkedin', 'facebook', 'twitter', 'site', 'outraRede', 'fixo', 'celular'
    ];
    
    public function fisica(){
        return $this->hasOne(Fisica::class);
    }

    public function juridica(){
        return $this->hasOne(Juridica::class);
    }
}
