<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Vaga;
use App\Juridica;
use App\Area;

class VagaController extends Controller
{

    public function index(){

        $areas = Area::all();
        return Response::json([
            'areas' => $areas
        ], 201);   

    }

    public function store(Request $request)
    {   
        $user = auth()->user()->id;
        $juridicas_id = Juridica::where('user_id', $user)->first()->id;
        $areas_id = $request->area;

        Vaga::create([
            'titulo' => $request->titulo,
            'local' => $request->local,
            'salario' => $request->salario,
            'beneficio' => $request->beneficios,
            'jornada' => $request->jornada,
            'requisito' => $request->requisitos,
            'juridicas_id' => $juridicas_id,
            'areas_id' => $areas_id
        ]);

        return Response::json([
            'message' => 'Vagas Cadastradas'
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
