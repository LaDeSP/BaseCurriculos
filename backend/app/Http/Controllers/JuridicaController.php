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
        $area = $pjuridica->area = $request->input('area');
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
            'user'=> auth()->user(),
            'foto'=> "http://localhost:8000/anon.jpg",
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

       $user_id = auth()->user()->id;
       User::where('id', $user_id)->update(['name'=>$request->nome]);

       $juridica = Juridica::where('user_id', $user_id)->first()->id;
       
       $con_id = Contato::insertGetId([
            'celular' => $request->celular,
            'fixo' => $request->fixo,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'site' => $request->site,
        ]);

        $end_id = Endereco::insertGetId([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
          //  'pais' => $request->pais,
            'cep' => $request->cep,
        ]);
        
        Juridica::where('user_id', $user_id)
        ->update(array(
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id
        ));
        
        return Response::json([
            'message' => 'Dados cadastrados com sucesso!',
            'OI' => auth()->user()
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

        User::where('id', $id)->update(['name'=>$request->nome]);
        
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
          //  'pais' => $request->pais,
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
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id
        ));
    
        return Response::json([
            'update ok',
        ]);
      
    }

    public function destroy($id)
    {
        $user = User::destroy($id);

        if($user){
            return Response::json(['softdelete ok']);
        }
    }

   /* public function destroy($id)
    {
    
        $end_id = Juridica::where('user_id', $id)->first()->enderecos_id;
        $cont_id = Juridica::where('user_id', $id)->first()->contatos_id;
        
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
    */

    
    public function messages_basic(){
        return $messages = [
            'name.required' => 'Insira um nome!',
            'name.max' => 'Insira nome com no máximo 50 caracteres',
            'area.required' => 'Selecione uma área.',
            'area.exists' => 'Selecione uma área válida.',
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
            'area' => 'required|exists:areas,id',
            'email' => 'required|max:50|email|unique:users,email',
            'password' => 'required|min:8|max:30',
            'cnpj' => 'required|cnpj|unique:juridicas,cnpj'
        ];
    }
    public function messages_addData(){
        return $messages = [
            'linkedin.max' => 'Insira linkedin com no máximo 50 caracteres.',
            'facebook.max' => 'Insira facebook com no máximo 50 caracteres.',
            'twitter.max' => 'Insira twitter com no máximo 50 caracteres.',
            'site.max' => 'Insira site com no máximo 50 caracteres.',
            'outraRede.max' => 'Insira outra rede com no máximo 50 caracteres.',
            //'pais.required' => 'Selecione um país!',
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
            'linkedin' => 'max:50',
            'facebook' => 'max:50',
            'twitter' => 'max:50',
            'site' => 'max:50',
            'outraRede' => 'max:50',
           // 'pais' => 'required',/* validar lista */
            'estado' => 'required',/* validar lista */
            'fixo' => 'nullable|digits:10',
            'celular' => 'required|digits_between: 10, 11',
            'rua' => 'required|max:50',
            'numero' => 'numeric|max:1000000',
            'complemento' => 'max:500',
            'bairro' => 'required|max:50',
            'cidade' => 'required|max:50',
            'cep'=> 'required|digits:8'
        ];
    }


    
}
