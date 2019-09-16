<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Traits\UserTrait;
use App\Juridica;
use App\Contato;
use App\Endereco;
use App\User;
use JWTAuth;

class JuridicaController extends Controller
{
    use UserTrait;
   
    public function store(Request $request)
    {   
        if(!$request->name){
            $error[] = 'Insira o nome!';
        }
        if(!$request->cnpj){
            $error[] = 'Insira o CNPJ!';
        }
        if(!$request->email){
            $error[] = 'Insira o email!';
        }
        if(!$request->ramo){
            $error[] = 'Insira o ramo!';
        }
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }

        $this->validate($request, [
            'name' => 'required',
            'cnpj' => 'required',
            'email' => 'required|email|unique:users',
            ]); 

            $this->register($request);
            
            $pjuridica = new Juridica();
            $cnpj = $pjuridica->cnpj = $request->input('cnpj');
            $ramo = $pjuridica->ramo = $request->input('ramo');
            $email = $request->input('email');
            $id = User::where('email', $email)->first()->id;
            $pjuridica->user_id = $id;

            $pjuridica->save();

            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
           // $user = User::find($id);
            //$token = auth()->login($user);
            return Response::json([
                'token'=> $token,
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'user_id'=> auth()->user()->id,
                'message' => 'Pessoa Jurídica cadastrada com sucesso!'
             ], 201); 
    }

    public function addData(Request $request){
        if(!$request->rua){
            $error[] = 'Insira uma rua!';
        }
        if(!$request->bairro){
            $error[] = 'Insira o bairro!';
        }
        if(!$request->cidade){
            $error[] = 'Insira uma cidade!';
        }
        if(!$request->estado){
            $error[] = 'Insira um estado!';
        }
        if(!$request->pais){
            $error[] = 'Insira um país!';
        }
        if(!$request->cep){
            $error[] = 'Insira o CEP!';
        }
        if(!$request->razao){
            $error[] = 'Insira sua razão social!';
        }
        if(!$request->missao){
            $error[] = 'Insira sua missão!';
        }
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }
       
        $con_id = Contato::insertGetId([
            'celular' => $request->input('celular'),
            'fixo' => $request->input('fixo'),
            'linkedin' => $request->input('linkedin'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'site' => $request->input('site'),
            'outraRede' => $request->input('outraRede')
        ]);

        $end_id = Endereco::insertGetId([
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'complemento' => $request->input('complemento'),
            'numero' => $request->input('numero'),
            'pais' => $request->input('pais'),
            'cep' => $request->input('cep')
        ]);
        
        Juridica::where('user_id', $request->input('user_id'))
        ->update(array(
            'razao' => $request->input('razao'),
            'missao' => $request->input('missao'),
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id

        ));

        return Response::json([
            'message' => 'Dados cadastrados com sucesso!'
         ], 201);

    }

    public function show($id)
    {
        $juridica = Juridica::with(['contato', 'endereco', 'user'])->where('user_id', $id)->get();
        return Response::json([
            'juridica' => $juridica
         ], 201);
    }


    public function update(Request $request, $id)
    {
        $end_id = Juridica::where('user_id', $id)->value('enderecos_id');
        $con_id = Juridica::where('user_id', $id)->value('contatos_id');

        //User::where('id', $id)->update(['name'=>$request->nome]);

        Endereco::where('id', $end_id)->update([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
            'pais' => $request->pais,
            'cep' => $request->cep
        ]);

        Contato::where('id', $con_id)->update([
            'celular' => $request->celular,
            'fixo' => $request->fixo,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'site' => $request->site,
            'outraRede' => $request->outraRede
        ]);

        Juridica::where('user_id', $id)->update(array(
                'razao' => $request->razao,
                'missao' => $request->missao,
                'contatos_id' => $con_id, 
                'enderecos_id' => $end_id
            ));

        return Response::json([
            'SEI LA MAN'=>$request->user_id
           ], 201);
      
      
    }

    public function destroy($id)
    {
    
        $end_id = Juridica::where('user_id', $id)->first()->enderecos_id;
        $cont_id = Juridica::where('user_id', $id)->first()->contatos_id;
        
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
