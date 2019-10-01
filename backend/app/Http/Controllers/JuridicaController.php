<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), JuridicaController::rules_basic(), JuridicaController::messages_basic());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
           ], 201);
        }
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
        $validator = Validator::make($request->all(), JuridicaController::rules_addData(), JuridicaController::messages_addData());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
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
        
        $validator = Validator::make($request->all(), JuridicaController::rules_addData(), JuridicaController::messages_addData());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
           ], 201);
        }

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

    
    public function messages_basic(){
        return $messages = [
            'name.required' => 'Insira um nome!',
            'name.max' => 'Insira nome com no máximo 50 caracteres',
            'ramo.required' => 'Insira um ramo!',
            'ramo.max' => 'Insira ramo com no máximo 50 caracteres',
            'email.required' => 'Insira um email!',
            'email.email' => 'Insira um email válido!',
            'email.unique' => 'Email inserido já existe!',
            'password.required' => 'Insira uma senha!',
            'password.min' => 'Senha tem que ter no mínimo 8 caracteres!',
            'password.max' => 'Senha tem que ter no máximo 30 caracteres!',
            'cpf.required' => 'Insira um CPF!',
            'cpf.cpf' => 'Insira um CPF válido!',
            'cpf.unique' => 'CPF inserido já foi cadastrado.'
        ];
    }

    public function rules_basic(){
        return [
           
            'name' => 'required|max:50',
            'ramo' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:30',
            'cnpj' => 'required|cnpj|unique:juridicas,cnpj'
        ];
    }
    public function messages_addData(){
        return $messages = [
            'razao.required' => 'Insira uma razão!',
            'razao.max' => 'Insira razão com no máximo 50 caracteres.',
            'missao.required' => 'Insira uma missão!',
            'missao.max' => 'Insira missão com no máximo 500 caracteres.',
            'linkedin.max' => 'Insira linkedin com no máximo 50 caracteres.',
            'facebook.max' => 'Insira facebook com no máximo 50 caracteres.',
            'twitter.max' => 'Insira twitter com no máximo 50 caracteres.',
            'site.max' => 'Insira site com no máximo 50 caracteres.',
            'outraRede.max' => 'Insira outra rede com no máximo 50 caracteres.',
            'pais.required' => 'Selecione um país!',
            'estado.required' => 'Selecione um estado!',
            'fixo.required' => 'Insira um número fixo!',
            'fixo.digits' => 'Número fixo precisa de 10 digitos! (DDD+numero)',
            'celular.required' => 'Insira um número de celular!',
            'celular.digits_between' => 'Número de celular precisa de 10 ou 11 digitos! (DDD+numero)',
            'rua.required' => 'Insira uma rua!',
            'rua.max' => 'Insira rua com no máximo 50 caracteres.',
            'numero.max' => 'Insira número com no máximo 50 caracteres.',
            'complemento.max' => 'Insira complemento com no máximo 500 caracteres.',
            'bairro.required' => 'Insira um bairro!',
            'bairro.max' => 'Insira bairro com no máximo 50 caracteres.',
            'cidade.required' => 'Insira uma cidade!',
            'cidade.max' => 'Insira cidade com no máximo 50 caracteres.',
            'cep.required' => 'Insira um CEP!',
            'cep.digits' => 'Insira CEP válido!'
        ];
    }
    public function rules_addData(){
        return [
            'razao' => 'required|max:50',
            'missao' => 'required|max:500',
            'linkedin' => 'max:50',
            'facebook' => 'max:50',
            'twitter' => 'max:50',
            'site' => 'max:50',
            'outraRede' => 'max:50',
            'pais' => 'required',
            'estado' => 'required',
            'fixo' => 'required|digits:10',
            'celular' => 'required|digits_between: 10, 11',
            'rua' => 'required|max:50',
            'numero' => 'max:50',
            'complemento' => 'max:500',
            'bairro' => 'required|max:50',
            'cidade' => 'required|max:50',
            'cep'=> 'required|digits:8'
        ];
    }


    
}
