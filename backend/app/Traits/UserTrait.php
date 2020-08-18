<?php 

namespace App\Traits;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

use Response;
use JWTAuth;

trait UserTrait {
    
    public function register(Request $request){
        
      
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
            'status' => 'ATIVO'
        ]);

        $user->save();

    }

}
