<?php

namespace App;

use App\Upload;
use App\Juridica;
use App\Fisica;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes, SoftCascadeTrait;
    use Notifiable;

  
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $softCascade = ['juridica'];

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
