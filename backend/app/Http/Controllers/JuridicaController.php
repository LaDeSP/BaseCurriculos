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

            $user = User::first();
            $token = JWTAuth::fromUser($user);
            return Response::json([
                'token'=> $token,
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'user_id'=> $id
             ], 201); 
    }

    public function edit($id)
    {
        $cursos = Curso::all();
        $instituicoes = Instituicao::all();
        $campuses = Campus::all();
        
        $aluno = Aluno::find($id);
    
        return Response::json([
            'cursos' => $cursos, 
            'instituicoes' => $instituicoes,
            'campuses' => $campuses
        ], 201);

    }

    public function addData(Request $request){

        $contato = new Contato();
        $endereco = new Endereco();

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
            'msg' => 'deu ok'
         ], 201);

    }

    public function update(Request $request)
    {
      
    }

    public function destroy($id)
    {
        //deleto pessoa, aluno, telefone e endereço, dps altero os ids de end e tel pra poder deletar cascada
        //user não é deletado quando aluno é deletado
        $end_id = Aluno::where('id', $id)->first()->end_id;
        $tel_id = Aluno::where('id', $id)->first()->tel_id;
        $pessoa_id = Aluno::where('id', $id)->first()->pessoa_id;
        $user_id = Pessoa::where('id', $pessoa_id)->first()->user_id;
        $target = Pessoa::where('id', $pessoa_id)->first()->nome;
        
        $pessoa = Pessoa::find($pessoa_id);
        $pessoa->delete();

        $end = Endereco::find($end_id);
        $end->delete();

        $tel = Telefone::find($tel_id);
        $tel->delete();

        $user = User::find($user_id);
        $user->delete();

        $log = new Log();
        $log->log('deletou', 'aluno', $target);

        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }
    
}
