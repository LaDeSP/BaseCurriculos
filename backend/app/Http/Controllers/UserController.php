<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exception\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Upload;
use App\Juridica;
use App\Fisica;
use App\Vaga;
use JWTAuth;
use Response;

class UserController extends Controller implements JWTSubject
{
    public function index(){
        $usersJuridica = User::where('role', 'JURIDICA')->get();
        return Response::json([
            'usersJuridica'=>$usersJuridica
        ]);
    }

    public function login(Request $request){
        
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->withTrashed()->first();

        if(!$user){
            $error[] = 'Email informado não está cadastrado.';
            return Response::json([
                'error' => $error
            ], 200);
        }else if($user->deleted_at != null){
            if(Hash::check($request->password, $user->password)){
                $token = JWTAuth::fromUser($user);
                auth()->login($user);
                return Response::json([
                    'token' => $token,
                    'user' => auth()->user()
                ]);
            }
        }                
        try{
            JWTAuth::factory()->setTTL(1440);
            if(!$token = JWTAuth::attempt($credentials)){
                $error[] = 'Email ou senha incorretos.';
                return response()->json([
                    'error' => $error
                ], 200);
            }
        }catch(JWTException $e){
            return response()->json([
                'error' => 'could not create token'
            ], 500);
        }
     
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
            'foto'=>$path,
            'expires' => auth('api')->factory()->getTTL() * 60,
            'id' => auth()->user()->id
        ], 201);
        
      
    }

    public function logout(){
        
        auth()->logout();

        return response()->json(['message' => auth()->user(), 'logged out' => 'true']);
    }

    public function activateAccount($user_id){

        User::withTrashed()->where('id', $user_id)->restore();
        $user = User::find($user_id);
       
        $role = User::where('id', $user_id)->get()->first()->role;

        if($role === 'FISICA'){
            $fisica_id = Fisica::withTrashed()->where('user_id', $user_id)->get()->first()->id;
            Fisica::withTrashed()->find($fisica_id)->restore();
        }
        else{
            $juridica_id = Juridica::withTrashed()->where('user_id', $user_id)->get()->first()->id;
            Juridica::withTrashed()->find($juridica_id)->restore();
        }

        $token = JWTAuth::fromUser($user);
        auth()->login($user);

        return Response::json([
            'conta reativada',
            'token'=>$token,
            'user'=> auth()->user(),
        ]);
    }

    public function destroy($id){  
        
       $user = User::find($id); 
       $user->delete();      

        if($user){
            return Response::json(['soft deleted']);
        }
        
    }

    public function handleUserStatus(Request $request){
        if($request->action === 'act'){
            User::where('id', $request->userId)->update(['status'=>'ATIVO']);
        }else if($request->action == 'deact'){
            User::where('id', $request->userId)->update(['status'=>'INATIVO']);
        }

        return Response::json([$this->index()->original]);
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
