<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Upload;
use JWTAuth;
use Response;

class UserController extends Controller implements JWTSubject
{
    public function login(Request $request){
        
       /* $validator = Validator::make($request->all(), UserController::rules(), UserController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        */   
        if (!(User::where('email', '=', $request->input('email'))->exists())){
            return Response::json([
                'error' => 'Email informado não está cadastrado.'
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
      $teste = User::where('id', $user_id)->first();
      $path="https://source.unsplash.com/QAB-WJcbgJk/60x60";
   
        
      if ($teste->fisica){
          if(Upload::where('fisicas_id', $teste->fisica->id)->exists()){
            $foto = Upload::where('fisicas_id', $teste->fisica->id)->first();
            $path = "http://localhost:8000/storage/".$foto->path;
          }  
      }
      else if($teste->juridica){
        if(Upload::where('juridicas_id', $teste->juridica->id)->exists()){
            $foto = Upload::where('juridicas_id', $teste->juridica->id)->first();
            $path = "http://localhost:8000/storage/".$foto->path;
        }
      }
      
      
      

      return Response::json([
        'token'=>$token,
        'user' => auth()->user(),
        'foto'=>$path
     ], 201);
        
      
    }
    public function teste(){
        $teste = User::where('id', '1')->get();
        dd(gettype($teste));
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
