<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{   protected $fillable = ['filename', 'mime', 'path', 'size', 'curriculos_id', 'user_id'];
    
    public function curriculo(){
        return $this->hasMany(Curriculo::class);
    }

}
