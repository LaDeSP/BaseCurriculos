<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Response;
use App\Vaga; 
use App\Curriculo; 
use App\User; 

class BuscaController extends Controller
{
    public function buscaVagas($keywords){

        $vagas = Vaga::with(['area'])->where('titulo', 'like', '%' . $keywords . '%')->orWhere('descricao', 'like', '%' . $keywords . '%')->get();


        return response()->json($vagas);
    }

    public function buscaVagasAvancadas($keywords=null, $cargo=null, $beneficio=null, $jornada=null, $requisitos=null, $area=null){
        if ($keywords=="undefined"){
            $keywords=null;
        }
        if ($cargo=="undefined"){
            $cargo=null;
        }
        if ($beneficio=="undefined"){
            $beneficio=null;
        }
        if ($jornada=="undefined"){
            $jornada=null;
        }
        if ($requisitos=="undefined"){
            $requisitos=null;
        }
        if ($area=="undefined"){
            $area=null;
        }

        $vagas = Vaga::with(['area'])
                ->when($keywords,function($query, $keywords){
                    $query->where('titulo', 'like', '%' . $keywords . '%')->orWhere('descricao', 'like', '%' . $keywords . '%');
                })
                ->when($cargo,function($query, $cargo){
                    $query->where('cargo', 'like', '%' . $cargo . '%');
                })
                ->when($beneficio, function($query, $beneficio){
                    $query->where('beneficio', 'like', '%' . $beneficio . '%');
                })
                ->when($jornada, function($query, $jornada){
                    $query->where('jornada', 'like', '%' . $jornada . '%');
                })
                ->when($requisitos, function($query, $requisitos){
                    $query->where('requisito', 'like', '%' . $requisitos . '%');
                })
                ->when($area, function($query, $area){
                    $query->where('areas_id', $area);
                })
                ->get();

        return response()->json($vagas);
    }

    public function buscaCurriculos($keywords){
        $curriculos = Curriculo::with(['fisica.user', 'fisica.endereco', 'area'])->where('qualificacoes', 'like', '%' . $keywords . '%')->get();


        return response()->json($curriculos);
    }

    public function buscaCurriculosAvancadas($keywords=null, $escolaridade=null, $objetivos=null, $historicoProfissional=null, $cidade=null, $nome=null, $area=null){
        if ($keywords=="undefined"){
            $keywords=null;
        }
        if ($escolaridade=="undefined"){
            $escolaridade=null;
        }
        if ($objetivos=="undefined"){
            $objetivos=null;
        }
        if ($historicoProfissional=="undefined"){
            $historicoProfissional=null;
        }
        if ($cidade=="undefined"){
            $cidade=null;
        }
        if($nome=="undefined"){
            $nome=null;
        }
        if($area=="undefined"){
            $area=null;
        }

        $curriculos = Curriculo::select('curriculos.*')
                ->with(['fisica.user', 'fisica.endereco', 'area'])
                ->join('fisicas', 'fisicas.id', '=', 'curriculos.fisicas_id')
                ->join('enderecos', 'enderecos.id', '=', 'fisicas.enderecos_id')
                ->join('users', 'users.id', '=', 'fisicas.user_id')
                ->when($keywords,function($query, $keywords){//fazer joins com fisica e endereço. mas n lembro como faz kkk 
                    $query->where('qualificacoes', 'like', '%' . $keywords . '%');
                })
                ->when($escolaridade,function($query, $escolaridade){
                    $query->where('escolaridade', 'like', '%' . $escolaridade . '%');
                })
                ->when($objetivos, function($query, $objetivos){
                    $query->where('objetivos', 'like', '%' . $objetivos . '%');
                })
                ->when($historicoProfissional, function($query, $historicoProfissional){
                    $query->where('historicoProfissional', 'like', '%' . $historicoProfissional . '%');
                })
                ->when($cidade, function($query, $cidade){
                    $query->where('enderecos.cidade', 'like', '%' . $cidade . '%');
                })
                ->when($nome, function($query, $nome){
                    $query->where('users.name', 'like', '%' . $nome . '%');
                })
                ->when($area, function($query, $area){
                    $query->where('areas_id', $area);
                })
                ->get();

        return response()->json($curriculos);
    }

    /*public function buscaVagaIndicada($userId){
        $user = User::findOrFail($userId);
        $curriculo = $user->fisica->curriculo;

        $vagas = Vaga::with(['area'])
                ->where('requisito', 'like', '%' . $curriculo->qualificacoes . '%')
                ->orWhere('requisito', 'like', '%' . $curriculo->historicoProfissional . '%')
                ->orWhere('requisito', 'like', '%' . $curriculo->objetivos . '%')
                ->orWhere('descricao', 'like', '%' . $curriculo->objetivos . '%')
                ->orWhere('descricao', 'like', '%' . $curriculo->qualificacoes . '%')
                ->orWhere('descricao', 'like', '%' . $curriculo->historicoProfissional . '%')
                ->orWhere('titulo', 'like', '%' . $curriculo->area->tipo . '%')
                ->orWhere('titulo', 'like', '%' . $curriculo->objetivos . '%')
                ->orWhere('titulo', 'like', '%' . $curriculo->qualificacoes . '%')
                ->orWhere('titulo', 'like', '%' . $curriculo->historicoProfissional . '%')
                ->orWhere('salario', 'like', '%' . $curriculo->pretensao . '%')
                ->orWhere('jornada', 'like', '%' . $curriculo->objetivos . '%')
                ->orWhere('areas_id', $curriculo->areas_id)
                ->get();

        return response()->json($vagas);
    }*/

    public function buscaVagaIndicada($userId){
        $user = User::findOrFail($userId);
        $curriculo = $user->fisica->curriculo;
        $palavrasQualificacaoPrevia=explode(" ",$curriculo->qualificacoes);
        $palavrasHistoricoPrevia=explode(" ",$curriculo->historicoProfissional);
        $palavrasObjetivosPrevia=explode(" ",$curriculo->objetivos);
        
        $palavrasQualificacao=BuscaController::tratarPalavras($palavrasQualificacaoPrevia);
        $palavrasHistorico=BuscaController::tratarPalavras($palavrasHistoricoPrevia);
        $palavrasObjetivos=BuscaController::tratarPalavras($palavrasObjetivosPrevia);
        $i=0;
        foreach ($palavrasQualificacao as $palavra){
            $vagas = Vaga::with(['area'])
                ->where('requisito', 'like', '%' . $palavra . '%')
                ->orWhere('descricao', 'like', '%' . $palavra . '%')
                ->orWhere('titulo', 'like', '%' . $palavra . '%')
                ->orWhere('areas_id', $curriculo->areas_id)
                ->orWhere('salario', 'like', '%' . $curriculo->pretensao . '%')//pensando se faço um explode pro pretensao
                ->orWhere('titulo', 'like', '%' . $curriculo->area->tipo . '%')
                ->get();
            
            if($i==0){
                $vagastotal=$vagas;
            }
            else{

                $mergedCollection = $vagastotal->toBase()->merge($vagas);
                $vagastotal = $mergedCollection;
            }
            $i++;

        }

        foreach ($palavrasHistorico as $palavra){
            $vagas = Vaga::with(['area'])
                ->where('requisito', 'like', '%' . $palavra . '%')
                ->orWhere('descricao', 'like', '%' . $palavra . '%')
                ->orWhere('titulo', 'like', '%' . $palavra . '%')
                ->get();
            
            $mergedCollection = $vagastotal->toBase()->merge($vagas);
            $vagastotal = $mergedCollection;
        }

        foreach ($palavrasObjetivos as $palavra){
            $vagas = Vaga::with(['area'])
                ->where('requisito', 'like', '%' . $palavra . '%')
                ->orWhere('descricao', 'like', '%' . $palavra . '%')
                ->orWhere('titulo', 'like', '%' . $palavra . '%')
                ->orWhere('jornada', 'like', '%' . $palavra . '%')
                ->get();
            
            $mergedCollection = $vagastotal->toBase()->merge($vagas);
            $vagastotal = $mergedCollection;
        }
        

        
        $collection = collect($mergedCollection);
        $unique = $collection->unique('id');
        $unique_data = $unique->values()->all();
        

        return response()->json($unique_data);
    }

    public function tratarPalavras($array){
        $resultado = [];
        foreach ($array as $palavra){
            BuscaController::removeAcento($palavra);
            if($palavra=="de"||$palavra=="com"||$palavra=="e"||$palavra=="em"||$palavra=="pela"||$palavra=="Com"||$palavra=="na"||$palavra==""||
               $palavra=="ou"||$palavra=="como"||$palavra=="por"||$palavra=="pois"||$palavra=="porque"||$palavra=="uma"||$palavra=="um"||
               $palavra=="que"||$palavra=="logo"||$palavra=="mas"){
                unset($palavra);
            }
            else{
                $resultado[]=$palavra;
            }
        }
        return $resultado;
    }

    public function removeAcento($palavra){
        if(strstr($palavra, ',', true)){
            $palavra=str_replace(",", "", $palavra);
        }
        if(strstr($palavra, '.', true)){
            $palavra=str_replace(".", "", $palavra);
        }
        if(strstr($palavra, ';', true)){
            $palavra=str_replace(";", "", $palavra);
        }
        if(strstr($palavra, ':', true)){
            $palavra=str_replace(":", "", $palavra);
        }
        if(strstr($palavra, '?', true)){
            $palavra=str_replace("?", "", $palavra);
        }
        if(strstr($palavra, '!', true)){
            $palavra=str_replace("!", "", $palavra);
        }
        return $palavra;
    }
    
}
