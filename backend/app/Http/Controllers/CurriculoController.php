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
        
    public function store(Request $request){
      
        if(!$request->rua){
            $error[] = 'Insira a rua!';
        }
        if(!$request->bairro){
            $error[] = 'Insira o bairro!';
        }
        if(!$request->cidade){
            $error[] = 'Insira a cidade!';
        }
        if(!$request->estado){
            $error[] = 'Insira o estado!';
        }
        if(!$request->cep){
            $error[] = 'Insira o CEP!';
        }
        if(!$request->pais){
            $error[] = 'Insira o país!';
        }
        if(!$request->objetivos){
            $error[] = 'Insira seus objetivos!';
        }
        if(!$request->area){
            $error[] = 'Insira sua área!';
        }
        if(!$request->pretensao){
            $error[] = 'Insira sua pretensão salarial!';
        }
        if(!$request->qualificacoes){
            $error[] = 'Insira suas qualificações!';
        }
        if(!$request->historicoProfissional){
            $error[] = 'Insira seu histórico!';
        }
        if(!$request->escolaridade){
            $error[] = 'Insira sua escolaridade!';
        }
        if(!$request->nascimento){
            $error[] = 'Insira sua data de nascimento!';
        }
        if(!$request->genero){
            $error[] = 'Insira seu genero!';
        }
        if(!$request->estadoCivil){
            $error[] = 'Insira seu estado civil!';
        }
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }               
        
        $user_id = $request->input('user_id');
      
        $endereco = Fisica::where('user_id', $user_id)->first()->enderecos_id;
        if ($endereco){
            return Response::json([
                'ja existe o endereço'=>$endereco
               ], 201);
        }
        $contato = Fisica::where('user_id', $user_id)->first()->contatos_id;
        if ($contato){
            return Response::json([
                'ja existe o contato'=>$contato
               ], 201);
        }
        $fisica = Fisica::where('user_id', $user_id)->first()->id;
           
            $end_id = Endereco::insertGetId([
                'rua' => $request->rua,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'complemento' => $request->complemento,
                'numero' => $request->numero,
                'pais' => $request->pais,
                'cep' => $request->cep
            ]);
            
            $con_id = Contato::insertGetId([
                'celular' => $request->celular,
                'fixo' => $request->fixo,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'site' => $request->site,
                'outraRede' => $request->outraRede
            ]);

            Fisica::where('user_id', $user_id)
            ->update(array(
                'data_nascimento' => $request->nascimento,
                'genero'  => $request->genero,
                'estado_civil' => $request->estadoCivil,
                'contatos_id' => $con_id, 
                'enderecos_id' => $end_id
            ));

            Curriculo::create([
                'objetivos' => $request->objetivos,
                'areas_id' => $request->area,
                'pretensao' => $request->pretensao,
                'qualificacoes' => $request->qualificacoes,
                'historicoProfissional' => $request->historicoProfissional,
                'escolaridade' => $request->escolaridade,
                'fisicas_id' => Fisica::where('user_id', $user_id)->first()->id
            ]);
           
           return Response::json([
            'PORRAAAAAA'=>$request->input('user_id')
           ], 201);
        }

    public function show($id)
    {  
        $fisicas_id = Fisica::where('user_id', $id)->first()->id;

        $fisica = Fisica::with(['contato', 'endereco', 'user'])->where('user_id', $id)->get();

        $curriculo = Curriculo::with(['fisica'])->where('fisicas_id', $fisicas_id)->get();
        
        return Response::json([
           'curriculo' => $curriculo,
           'fisica' => $fisica
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $end_id = Fisica::where('user_id', $id)->value('enderecos_id');
        $con_id = Fisica::where('user_id', $id)->value('contatos_id');

        User::where('id', $id)->update(['name'=>$request->nome]);

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

        Fisica::where('user_id', $id)->update(array(
                'data_nascimento' => $request->nascimento,
                'genero'  => $request->genero,
                'estado_civil' => $request->estadoCivil
            ));
        
        $fisicas_id = Fisica::where('user_id', $id)->first()->id;

        Curriculo::where('fisicas_id', $fisicas_id)->update([
            'objetivos' => $request->objetivos,
            'areas_id' => $request->area,
            'pretensao' => $request->pretensao,
            'qualificacoes' => $request->qualificacoes,
            'historicoProfissional' => $request->historicoProfissional,
            'escolaridade' => $request->escolaridade
        ]);

        return Response::json([
            'SEI LA MAN'=>$request->input('user_id')
           ], 201);
      
      
    }


}
