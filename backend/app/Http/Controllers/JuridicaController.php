<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Juridica;
use App\Telefone;
use App\Endereco;
use App\User;

class JuridicaController extends Controller
{
   
    public function store(Request $request)
    {   
        $role = $request->input('role');

        $this->validate($request, [
            'name' => 'required',
            'cnpj' => 'required',
            'email' => 'required|email|unique:users',
            ]); 

        app('App\Http\Controllers\UserController')->register($request, $role);
            
            $pjuridica = new Juridica();
            $cnpj = $pjuridica->cnpj = $request->input('cnpj');
            $ramo = $pjuridica->ramo = $request->input('ramo');
            $email = $request->input('email');
            $id = User::where('email', $email)->first()->id;
            $pjuridica->user_id = $id;

            $pjuridica->save();

        app('App\Http\Controllers\UserController')->login($request);    

       
    }

    public function show($id)
    {  
        $aluno = Aluno::where('id', $id)->with('pessoa', 'endereco', 'telefone', 'instituicao', 'campus', 'curso')->get();
        return Response::json([
           'aluno' => $aluno
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
