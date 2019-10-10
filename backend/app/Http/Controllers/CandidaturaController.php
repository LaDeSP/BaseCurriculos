<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Vaga;
use App\Fisica;
use App\Juridica;
use App\Curriculo;
use App\Area;
use App\Agenda;
use App\Candidatura;

class CandidaturaController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;

        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $vaga_id = Vaga::where('juridicas_id', $juridica_id)->first()->id;
            $candidaturasJuridica = Candidatura::with(['vaga', 'curriculo'])->where('vagas_id', $vaga_id)->get();
            return Response::json([
                'candidaturas' => $candidaturasJuridica
            ]);
        }else{
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $curriculo_id = Curriculo::where('fisicas_id', $fisica_id)->first()->id;
            $candidatura_id = Candidatura::where('curriculos_id', $curriculo_id)->first()->id;
            $candidaturasFisica = Candidatura::with(['vaga', 'curriculo'])
                ->where('curriculos_id', $curriculo_id)->get();
            
            return Response::json([
                'candidaturasFisica'=>$candidaturasFisica
            ]);
        } 

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
                'curriculos_id' => $curriculos_id,
                'status'=>'AGUARDANDO'
            ]);
        }else{
            Vaga::where('id', $vaga_id)
            ->update([
                'status' => 'INATIVA'
            ]);
    
        }

        return Response::json([
            'Candidatura ok'
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
