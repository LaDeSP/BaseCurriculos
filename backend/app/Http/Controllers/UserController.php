<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\Auth;

use App\User;
use JWTAuth;
use Response;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), UserController::rules(), UserController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }   
       
        
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

    public function messages(){
        return $messages = [
            'email.required' => 'Insira um email!',
            'email.email' => 'Insira um email válido!',
            'password.required' => 'Insira uma senha!',
            'password.min' => 'Insira uma senha com no mínimo 8 caracteres!',
            'password.max' => 'Insira uma senha com no máximo 30 caracteres!'

        ];
    }

    public function rules(){
        return [
            'email' => 'required|email',
            'password' => 'required|min:8|max:30'
        ];
    }
}
