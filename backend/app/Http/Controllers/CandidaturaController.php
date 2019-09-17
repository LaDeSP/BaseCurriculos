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

class CandidaturaController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;
        $jur_id = Juridica::where('user_id', $user_id)->first()->id;
        $vaga_id = Vaga::where('juridicas_id', $jur_id)->first()->id;
        $candidaturas =  Candidatura::with(['vaga', 'curriculo'])->where('vagas_id', $vaga_id)->get();
        $curriculo_id = Candidatura::where('vagas_id', $vaga_id)->first()->curriculos_id; 
       
        $fisica_id = Curriculo::where('id', $curriculo_id)->first()->fisicas_id;
        $fisicas = Fisica::with(['user'])->where('id', $fisica_id)->get();
        

        return Response::json([
            'candidaturas' => $candidaturas,
            'fisica'=> $fisicas
        ]);

    }

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
