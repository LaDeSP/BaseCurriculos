<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Fisica;
use App\Contato;
use App\Endereco;
use App\User;
use App\Traits\UserTrait;
use JWTAuth;

class FisicaController extends Controller
{
    use UserTrait;

    public function store(Request $request)
    {  
        if(!$request->name){
            $error[] = 'Insira o nome!';
        }
        if(!$request->cpf){
            $error[] = 'Insira o cpf!';
        }
        if(!$request->email){
            $error[] = 'Insira o email!';
        }
        
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }

        $this->validate($request, [
            'name' => 'required',
            'cpf' => 'required',
            'email' => 'required|email|unique:users',
            ]); 

        $this->register($request);
            
            $pfisica = new Fisica();
            $cpf = $pfisica->cpf = $request->input('cpf');
            $email = $request->input('email');
            $id = User::where('email', $email)->first()->id;
            $pfisica->user_id = $id;

            $pfisica->save();

            $user = User::first();
            $token = JWTAuth::fromUser($user);
            return Response::json([
                'token'=> $token,
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'user_id'=> $id,
                'message'=>'Pessoa física cadastrada com sucesso!'
             ], 201); 
       
    }

    public function show($id)
    {   
        $fisica = Fisica::with(['contato', 'endereco', 'user'])->where('user_id', $id)->get();
        return Response::json([
           'fisica' => $fisica
        ], 201);
    }

    public function destroy($id)
    {
        $end_id = Fisica::where('user_id', $id)->first()->enderecos_id;
        $cont_id = Fisica::where('user_id', $id)->first()->contatos_id;
        
        $user = User::find($id);
        $user->delete();

        $end = Endereco::find($end_id);
        $end->delete();

        $cont = Contato::find($cont_id);
        $cont->delete();
        
        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }
    
}
