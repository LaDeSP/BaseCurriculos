<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Response;
use App\Vaga; 
use App\Curriculo; 

class BuscaController extends Controller
{
    public function buscaVagas($keywords){

        $vagas = Vaga::where('titulo', 'like', '%' . $keywords . '%')->get();


        return response()->json($vagas);
    }

    public function buscaVagasAvancadas($keywords=null, $cargo=null, $beneficio=null, $jornada=null, $requisitos=null){
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

        $vagas = Vaga::when($keywords,function($query, $keywords){
                    $query->where('titulo', 'like', '%' . $keywords . '%');
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
                ->get();

        return response()->json($vagas);
    }

    public function buscaCurriculos($keywords){
        $curriculos = Curriculo::where('qualificacoes', 'like', '%' . $keywords . '%')->get();


        return response()->json($curriculos);
    }

    public function buscaCurriculosAvancadas($keywords=null, $escolaridade=null, $objetivos=null, $historicoProfissional=null, $cidade=null, $nome=null){
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

        $curriculos = Curriculo::when($keywords,function($query, $keywords){//fazer joins com fisica e endereço. mas n lembro como faz kkk 
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
                ->get();

        return response()->json($curriculos);
    }
    
}
