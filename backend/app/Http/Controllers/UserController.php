<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\Auth;

use App\User;
use JWTAuth;
use Response;

class UserController extends Controller
{
    public function login(Request $request){
        if(!$request->email){
            $error[] = 'Insira um email!';
        }
        if(!$request->password){
            $error[] = 'Insira uma senha!';
        }
        if(isset($error)){
            return Response::json([
            'error' => $error
            ], 201);
        }
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('email', 'password');
        //se try falhar, falhou em criar um token
        try{
            //tento usando as credenciais dadas, se não deu certo, quer dizer q token n foi criado
            if(!$token = JWTAuth::attempt($credentials)){
                //se n foi criado
                return response()->json([
                    'error' => 'invalid credentials'
                ], 401);
            }
        }catch(JWTException $e){
            return response()->json([
                'error' => 'could not create token'
            ], 500);
        }
      //  $user = JWTAuth::parseToken()->toUser();
      $name = User::where('email', $request->input('email'))->first()->name;
      $role = User::where('email', $request->input('email'))->get()->first()->role;
     
      $user_id = User::where('email', $request->input('email'))->get()->first()->id;

      return Response::json([
        'name'=> $name,
        'role' => $role,
        'user_id' => $user_id,
        'token'=>$token,
        'teste' => auth()->user()->role
     ], 201);
        
      
    }

    public function logout(){
        
        auth()->logout();

        return response()->json(['msg' => 'tchau....']);
    }

  
    
}
