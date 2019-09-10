<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $fillable = [
        'emailAlt', 'linkedin', 'facebook', 'twitter', 'site', 'outraRede', 'fixo', 'celular'
    ];
    
    public function pfisica(){
        return $this->hasOne(Fisica::class);
    }

    public function pjuridica(){
        return $this->hasOne(Juridica::class);
    }
}
