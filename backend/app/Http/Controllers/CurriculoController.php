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
      
        if(!$request->nome){
            $error[] = 'Insira um nome!';
        }
        else{
            if(strlen($request->nome)>50){
                $error[] = 'Insira um nome com no máximo 50 caracteres!';
            }
        }

        if(!$request->nascimento){
            $error[] = 'Insira sua data de nascimento!';
        }

        if(!$request->estadoCivil){
            $error[] = 'Insira seu estado civil!';
        }

        if(!$request->genero){
            $error[] = 'Insira seu genero!';
        }

        if($request->linkedin){
            if(strlen($request->linkedin)>50){
                $error[] = 'Insira um linkedin com no máximo 50 caracteres!';
            }
        }

        if($request->facebook){
            if(strlen($request->facebook)>50){
                $error[] = 'Insira um facebook com no máximo 50 caracteres!';
            }
        }

        if($request->twitter){
            if(strlen($request->twitter)>50){
                $error[] = 'Insira um twitter com no máximo 50 caracteres!';
            }
        }

        if($request->site){
            if(strlen($request->site)>50){
                $error[] = 'Insira o site com no máximo 50 caracteres!';
            }
        }

        if($request->outraRede){
            if(strlen($request->outraRede)>50){
                $error[] = 'Insira sua outra rede com no máximo 50 caracteres!';
            }
        }

        if($request->emailAlt){
            if(!filter_var($request->emailAlt, FILTER_VALIDATE_EMAIL)){
                $error[] = 'Insira email válido no campo email alternativo!';
            }
            else if(strlen($request->emailAlt)>50){
                $error[] = 'Insira seu email alternativo com no máximo 50 caracteres!';
            }
        }

        if(!$request->pais){
            $error[] = 'Insira o país!';
        }

        if(!$request->estado){
            $error[] = 'Insira o estado!';
        }

        if(!$request->fixo){
            $error[] = 'Insira número fixo!';
        }
        else{
            /*if(CurriculoController::celular($request->fixo)==false){
                $error[] = 'Digite número fixo válido!';
            }*/
        }
        
        if(!$request->celular){
            $error[] = 'Insira número de celular!';
        }
        else{ 
            /*if(CurriculoController::celular($request->celular)==false){
                $error[] = 'Digite celular válido!';
            } */
        }
        
        if(!$request->rua){
            $error[] = 'Insira a rua!';
        }
        else {
            if(strlen($request->rua)>50){
                $error[] = 'Insira sua rua com no máximo 50 caracteres!';
            }
        }

        if(!$request->bairro){
            $error[] = 'Insira o bairro!';
        }
        else {
            if(strlen($request->bairro)>50){
                $error[] = 'Insira seu bairro com no máximo 50 caracteres!';
            }
        }

        if(!$request->cidade){
            $error[] = 'Insira a cidade!';
        }
        else {
            if(strlen($request->cidade)>50){
                $error[] = 'Insira sua cidade com no máximo 50 caracteres!';
            }
        }
        
        if(!$request->cep){
            $error[] = 'Insira o CEP!';
        }
        else{
            /*if(CurriculoController::validarCep($request->cep)==false){
                $error[] = 'Digite CEP válido!';
            }*/
        }
        
        if(!$request->objetivos){
            $error[] = 'Insira seus objetivos!';
        }
        else{
            if(strlen($request->objetivos)>500){
                $error[] = 'Insira seus objetivos com no máximo 500 caracteres!';
            }
        }

        if(!$request->area){
            $error[] = 'Insira sua área!';
        }

        if(!$request->pretensao){
            $error[] = 'Insira sua pretensão salarial!';
        }
        else{
            if (!is_numeric($request->pretensao)){
                $error[] = 'Insira sua pretensão salarial apenas com números!';
            }
            if($request->pretensao<1){
                $error[] = 'Insira pretensão salarial com valor maior que 1!';
            }
        }

        if(!$request->escolaridade){
            $error[] = 'Insira sua escolaridade!';
        }

        if(!$request->qualificacoes){
            $error[] = 'Insira suas qualificações!';
        }
        else{
            if(strlen($request->qualificacoes)>500){
                $error[] = 'Insira suas qualificações com no máximo 500 caracteres!';
            }
        }

        if(!$request->historicoProfissional){
            $error[] = 'Insira seu histórico!';
        }
        else{
            if(strlen($request->historicoProfissional)>500){
                $error[] = 'Insira seu histórifo profissional com no máximo 500 caracteres!';
            }
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

    function celular($telefone){
        $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));
        $tam=strlen($telefone);
        if($tam==10){
            $regexTelefone = "^[0-9]{10}$^";
        }
        else { //quando for 11. se for diferente de 10 e 11 vai dar false ali embaixo 
            $regexTelefone = "^[0-9]{11}$^";
        }
    
        //$regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
        if (preg_match($regexTelefone, $telefone)) {
            return true;
        }else{
            return false;
        }
    }
    function validarCep($cep) {
        // retira espacos em branco
        $cep = trim($cep);
        // expressao regular para avaliar o cep
        $avaliaCep = ereg("^[0-9]{8}$", $cep);
        
        // verifica o resultado
        if(!$avaliaCep) {            
            return "false";
        }
        else{
            return "true";
        }
    }


}
