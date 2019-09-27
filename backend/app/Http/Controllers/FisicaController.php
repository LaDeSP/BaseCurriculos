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
        else{
            if(strlen($request->name)>50){
                $error[] = 'Insira nome com no máximo 50 aracteres!';
            }
        }

      /*  $validaCPF = FisicaController::validaCPF($request->cpf);
        if($validaCPF!="true"){
            $error[] = $validaCPF;
        } */
        if(!$request->email){
            $error[] = 'Insira o email!';
        }
        else{
            $buscaEmail = User::where('email', $request->email)->first();
            if($buscaEmail){
                $error[] = 'Email inserido já foi cadastrado.';
            }
            else {
                if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
                    $error[] = 'Insira email válido!';
                }
            }
        }
        if(!$request->password){
            $error[] = 'Insira uma senha!';
        }
        else{
            if(strlen($request->password)<8){
                $error[] = 'Insira uma senha com no mínimo 8 caracteres!';
            }
            else if(strlen($request->password)>30){
                $error[] = 'Insira uma senha com no máximo 30 caracteres!';
            }
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

            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
            //$user = User::first();
            //$token = JWTAuth::fromUser($user);
            return Response::json([
                'token'=> $token,
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'user_id'=> auth()->user()->id,
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

    function validaCPF($cpf) {

        // Verifica se um número foi informado
        if(empty($cpf)) {
            return "Insira um CPF";
        }
    
        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        $buscaCPF = Fisica::where('cpf', $cpf)->first();
        if($buscaCPF){
            return "CPF inserido já foi cadastrado.";
        }
        
        // Verifica se o numero de digitos informados é igual a 11 
        if (strlen($cpf) != 11) {
            return "CPF Inválido";
        }
        // Verifica se nenhuma das sequências invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
            return "CPF Inválido";
         // Calcula os digitos verificadores para verificar se o
         // CPF é válido
         } else {   
            
            for ($t = 9; $t < 11; $t++) {
                
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return "CPF Inválido";
                }
            }
    
            return "true";
        }
    }
    
}
