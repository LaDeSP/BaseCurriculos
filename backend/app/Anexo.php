<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{       
    public function curriculo(){
        return $this->hasMany(Curriculo::class);
    }

}
