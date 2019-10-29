<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Vaga;
use App\Fisica;
use App\Juridica;
use App\Curriculo;
use App\Area;
use App\User;
use App\Agenda;
use App\Candidatura;

class CandidaturaController extends Controller
{
    public function teste(){
    
      /*  $vagasCandidaturas =  Candidatura::with(['vaga', 'curriculo'])
            ->join('vagas', function($join){
            $join->on('vagas.id', '=', 'candidaturas.vagas_id')
            ->where('vagas.juridicas_id', '=', 1);
            })->get();
     */
        /*    $candidaturasJuridica =  Candidatura::with(['vaga', 'curriculo.fisica.contato', 'curriculo.fisica.user'])
            ->join('vagas', function($join) {
            $join->on('vagas.id', '=', 'candidaturas.vagas_id')
            ->where('vagas.juridicas_id', '=', 1);
            })->get();

          */

          $candidaturasJuridica =  Candidatura::with(['vaga', 'curriculo.fisica.contato', 'curriculo.fisica.user'])
            ->whereHas('vaga', function($query) { 
                $query->where('id', '=', 1);
            })->get();
            
            dd($candidaturasJuridica);
      //  dd($vagasCandidaturas[0]->vaga->titulo);
    }

    public function index(){

        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $candidaturasJuridica =  Candidatura::with(['vaga', 'curriculo.fisica.contato', 'curriculo.fisica.user'])
            ->whereHas('vaga', function($query) use ($juridica_id){ 
                $query->where('juridicas_id', '=', $juridica_id);
            })->get();
        
            return Response::json([
                'candidaturas' => $candidaturasJuridica,
                'id'=> $juridica_id
            ]);
        }else{
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $curriculo_id = Curriculo::where('fisicas_id', $fisica_id)->first()->id;
            $candidatura_id = Candidatura::where('curriculos_id', $curriculo_id)->first()->id;
            $candidaturas_fisica = Candidatura::with(['vaga', 'curriculo'])
                ->where('curriculos_id', $curriculo_id)->get();
            
            return Response::json([
                'candidaturas'=>$candidaturas_fisica
            ]);
        } 

    }

    public function store(Request $request)
    {   
        $vaga_id = $request->vaga_id;
        $fisicas_id = Fisica::where('user_id', $request->user_id)->first()->id;
        $curriculos_id = Curriculo::where('fisicas_id', $fisicas_id)->first()->id;
      //  $quantVaga = Vaga::where('id', $vaga_id)->first()->quantidade;
       // $quantCandidato = Candidatura::where('vagas_id', $vaga_id)->count();

//        if($quantCandidato < $quantVaga){
            Candidatura::create([
                'vagas_id' => $vaga_id,
                'curriculos_id' => $curriculos_id,
                'status'=>'AGUARDANDO'
            ]);
  //      }else{
    //        Vaga::where('id', $vaga_id)
      //      ->update([
        //        'status' => 'INATIVA'
         //   ]);
      //}
      $user_id = auth()->user()->id; 
      $user = User::find($user_id);
      $vagas = Vaga::whereNotIn('id', function($q) use ($user){
        $q->from('candidaturas')
            ->select('vagas_id')
            ->where('curriculos_id', '=', $user->fisica->curriculo->id);
        })
        ->with('area')->get();
    
        return Response::json([
            'Candidatura ok',
            'vagas'=>$vagas
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
