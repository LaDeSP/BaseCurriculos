<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Fisica;
use App\Telefone;
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
        $fisica = Fisica::where('user_id', $id)->with('contato', 'endereco', 'user')->get();
        return Response::json([
           'fisica' => $fisica
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

    public function update(Request $request, $id)
    {
        $alu = Aluno::find($id);
        if(isset($alu)) {
           
            //entro na tabela pessoa, busco o id dela q é igual ao id de pessoa_id dentro de aluno, pego o nome apenas
            //$alu->pessoa()->where('id', $alu->pessoa_id)->update(['nome'=> $request->input('nome')]);
            $target = $alu->pessoa()->where('id', $alu->pessoa_id)->get()->first()->nome;

            $alu->telefone()->where('id', $alu->tel_id)->update([
                'fixo' => $request->input('fixo'),
                'celular' => $request->input('celular')
                ]);

            $alu->endereco()->where('id', $alu->end_id)->update([
                'rua'=> $request->input('rua'),
                'bairro' => $request->input('bairro'),
                'cidade' => $request->input('cidade'),
                'cep' => $request->input('cep')
                ]);

            $alu->inst_id = $request->input('instituicao');
            $alu->campus_id = $request->input('campus');
            $alu->curso_id = $request->input('curso');
            $alu->semestre = $request->input('semestre');
            $alu->save();

            $log = new Log();
            $log->log('editou', 'aluno', $target);
        }
        
        return Response::json([
            'msg' => 'update ok'
         ], 201);
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
