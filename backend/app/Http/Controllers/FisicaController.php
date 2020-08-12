<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
        $validator = Validator::make($request->all(), FisicaController::rules(), FisicaController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }

        $this->register($request);
            
        $pfisica = new Fisica();
        $cpf = $pfisica->cpf = $request->input('cpf');
        $email = $request->input('email');
        $id = User::where('email', $email)->first()->id;
        $pfisica->user_id = $id;

        $pfisica->save();

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        
        return Response::json([
            'token'=> $token,
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'user_id'=> auth()->user()->id,
            'user'=>auth()->user(),
            'foto'=> "http://localhost:8000/anon.jpg",
            'message'=>'Pessoa física cadastrada com sucesso!'
        ], 201); 
       
    }

    public function show($id)
    {   
        $fisica = Fisica::with(['contato', 'endereco', 'user'])
                    ->where('user_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return Response::json([
           'fisica' => $fisica
        ], 201);
    }

    public function updateDadosCadastroFisica (Request $request){
        $user_id = auth()->user()->id; 
        $user = User::findOrFail($user_id);
        $fisica = $user->fisica;
        
        $validator = Validator::make($request->all(), FisicaController::rules_edit($user->id, $fisica->id), FisicaController::messages());
        
        if ($validator->fails()) {
            return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        
        $error = [];
        if($request->newPassword){
            if(!$request->password){
                $errorSenha[] = "Insira senha atual.";
                $error[] = $errorSenha;
                return Response::json([
                    'error' => $error
                ], 201);
            }
            if(!Hash::check($request->password, $user->password)){
                $errorSenha[] = "Senha atual errada.";
                $error[] = $errorSenha;
                return Response::json([
                    'error' => $error
                ], 201);
            }
            $user->password = Hash::make($request->newPassword);
        }
        $user->email = $request->email;
        $fisica->cpf = $request->cpf;
        
        $user->update();
        $fisica->update();
        return Response::json([
            'message'=>'Pessoa física atualizada com sucesso!',
            'cpf'=>$fisica->cpf,
            'email'=>$user->email,
        ], 201); 
    }

    public function destroy($id)
    {
        $end_id = Fisica::where('user_id', $id)->first()->enderecos_id;
        $cont_id = Fisica::where('user_id', $id)->first()->contatos_id;
        
        $user = User::find($id);
        $user->delete();

        if($end_id && $cont_id){
            $end = Endereco::find($end_id);
            $end->delete();

            $cont = Contato::find($cont_id);
            $cont->delete();
    
        }
        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }

    public function messages(){
        return $messages = [
            'name.required' => 'Insira um nome!',
            'name.max' => 'Insira nome com no máximo 250 caracteres',
            'email.required' => 'Insira um email!',
            'email.email' => 'Insira um email válido!',
            'email.unique' => 'Email inserido já existe!',
            'email.max' => 'Email com no máximo 250 caracteres',
            'password.required' => 'Insira uma senha!',
            'password.min' => 'Senha tem que ter no mínimo 8 caracteres!',
            'password.max' => 'Senha tem que ter no máximo 30 caracteres!',
            'newPassword.required' => 'Insira nova senha!',
            'newPassword.min' => 'Nova senha tem que ter no mínimo 8 caracteres!',
            'newPassword.max' => 'Nova senha tem que ter no máximo 30 caracteres!',
            'cpf.required' => 'Insira um CPF!',
            'cpf.cpf' => 'Insira um CPF válido!',
            'cpf.unique' => 'CPF inserido já foi cadastrado.'
        ];
    }

    public function rules(){
        return [
           
            'name' => 'required|max:250',
            'email' => 'required|max:250|email|unique:users,email',
            'password' => 'required|min:8|max:30',
            'cpf' => 'required|cpf|unique:fisicas,cpf'
        ];
    }

    public function rules_edit($email, $cpf){
        return [
            'email' => 'required|max:250|email|unique:users,email,'.$email,
            'password' => 'nullable|min:8|max:30',
            'newPassword' => 'nullable|min:8|max:30',
            'cpf' => 'required|cpf|unique:fisicas,cpf,'.$cpf
        ];
    }
    
}
