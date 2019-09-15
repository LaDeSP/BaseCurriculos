<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Vaga;
use App\Fisica;
use App\Juridica;
use App\Curriculo;
use App\Area;
use App\Candidatura;

class AgendaController extends Controller
{
    public function store(Request $request)
    {   
        $vaga_id = $request->vaga_id;
        $fisicas_id = Fisica::where('user_id', $request->user_id)->first()->id;
        $curriculos_id = Curriculo::where('fisicas_id', $fisicas_id)->first()->id;
        $quantVaga = Vaga::where('id', $vaga_id)->first()->quantidade;
        $quantCandidato = Candidatura::where('vagas_id', $vaga_id)->count();

        if($quantCandidato < $quantVaga){
            Candidatura::create([
                'vagas_id' => $vaga_id,
                'curriculos_id' => $curriculos_id
            ]);
        }else{
            Vaga::where('id', $vaga_id)
            ->update([
                'status' => 'INATIVA'
            ]);
    
        }

        return Response::json([
            'message' => 'Candidatura ok'
         ], 201);
    }
 

    public function show($id)
    {
        
        $candidaturas = Vaga::find($id);
    
        return Response::json([
            'vaga'=>$vaga
        ], 201);   

    }
    
}
