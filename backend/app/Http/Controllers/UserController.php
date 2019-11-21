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
    public function teste(){
        $teste = User::onlyTrashed()->get();
        dd($teste);
    }

    public function login(Request $request){
        
       /* $validator = Validator::make($request->all(), UserController::rules(), UserController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        */   
        $user = new User();
        $credentials = $request->only('email', 'password');
        if($a){
            try{
                if(!$token = JWTAuth::attempt($credentials)){
                    $error[] = 'Senha Inválida.';
                    return response()->json([
                        'error' => $error
                    ], 201);
                }
            }catch(JWTException $e){
                return response()->json([
                    'error' => 'could not create token'
                ], 500);
            }
        }

        if (!(User::where('email', '=', $request->input('email'))->exists())){
            $error[] = 'Email informado não está cadastrado.';
            return Response::json([
                'error' => $error
            ], 201);
        }
       
        //se try falhar, falhou em criar um token
        try{
            //tento usando as credenciais dadas, se não deu certo, quer dizer q token n foi criado
            if(!$token = JWTAuth::attempt($credentials)){
                $error[] = 'Senha Inválida.';
                return response()->json([
                    'error' => $error
                ], 201);
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
      $path="http://localhost:8000/anon.jpg";
   
        
    if ($teste->foto){
        if(Upload::where('user_id', $teste->id)->exists()){
          $foto = Upload::where('user_id', $teste->id)->first();
          $path = "http://localhost:8000/storage/".$foto->path;
        }  
    }
      
      
      

      return Response::json([
        'token'=>$token,
        'user' => auth()->user(),
        'foto'=>$path
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
            'email.max' => 'Email com no máximo 250 caracteres.',
            'password.required' => 'Insira uma senha!',
            'password.min' => 'Insira uma senha com no mínimo 8 caracteres!',
            'password.max' => 'Insira uma senha com no máximo 30 caracteres!'

        ];
    }

    public function rules(){
        return [
            'email' => 'required|max:250|email',
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
