<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexos extends Model
{       
    public function curriculos(){
        return $this->hasMany(\App\Curriculos::class);
    }

}
