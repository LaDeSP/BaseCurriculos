<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;


use App\Fisica;
use App\Curriculo;
use App\Contato;
use App\Endereco;
use App\User;

class CurriculoController extends Controller
{

    public function index()
    {
     
    }

    public function create()
    {
        //pode [9chamar aqui dps todos os países/estados pra serem listados de acordo na view

    }
    
    public function store(Request $request)
    {   
       

            $curriculo = new Curriculo();
            $contato = new Contato();
            $endereco = new Endereco();
            $pfisica = new Fisica();
            $user_id =  $request->input('user_id');

            $endereco->rua = $request->input('rua');
            $endereco->bairro = $request->input('bairro');
            $endereco->cidade = $request->input('cidade');
            $endereco->estado = $request->input('estado');
            $endereco->pais = $request->input('pais');
            $cep = $endereco->cep = $request->input('cep');

            $endereco->save();

            $email = $contato->emailAlt = $request->input('emailAlt');
            $contato->celular = $request->input('celular');
            $contato->fixo = $request->input('fixo');
            $contato->facebook = $request->input('facebook');
            $contato->twitter = $request->input('twitter');
            $contato->site = $request->input('site');
            $contato->outraRede = $request->input('outraRede');

            $contato->save();

            $curriculo->objetivos = $request->input('objetivos');
            $curriculo->area = $request->input('area');
            $curriculo->pretensao = $request->input('pretensao');
            $curriculo->qualificacoes = $request->input('qualificacoes');
            $curriculo->historicoProfissional = $request->input('historico');
            $curriculo->escolaridade = $request->input('escolaridade');
            
           Fisica::where('user_id', $user_id)
            ->update(array(
                'data_nascimento' => $request->input('nascimento'),
                'genero'  => $request->input('genero'),
                'estado_civil' => $request->input('estadoCivil'),
                'contatos_id' => $contato->id, //pega ultimo id inserido
                'enderecos_id' => $endereco->id

            ));

           $curriculo->fisicas_id = Fisica::where('user_id', $user_id)->first()->id;
           $curriculo->save();
         
       
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

    
    
}
