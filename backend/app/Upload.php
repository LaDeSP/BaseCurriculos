<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{   protected $fillable = ['filename', 'mime', 'path', 'size', 'curriculos_id', 'juridicas_id', 'fisicas_id'];
    
    public function curriculo(){
        return $this->hasMany(Curriculo::class);
    }

}
