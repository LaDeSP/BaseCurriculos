<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
  
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
   
    public function foto(){
    	return $this->belongsTo(Upload::class, 'id', 'user_id');
    }
    public function fisica(){
    	return $this->belongsTo(Fisica::class, 'id', 'user_id');
    }
    public function juridica(){
    	return $this->belongsTo(Juridica::class, 'id', 'user_id');
	}
}
