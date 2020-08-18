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
    public function index(){

        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $vagasCandidatura =  Candidatura::with(['vaga', 'curriculo.area', 'curriculo.fisica.contato', 'curriculo.fisica.user'])
                                ->whereHas('vaga', function($query) use ($juridica_id){ 
                                    $query->where('juridicas_id', '=', $juridica_id)->groupBy('vagas_id');
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();

            $collection = collect($vagasCandidatura);
            $unique = $collection->unique('vagas_id');
            $unique_data = $unique->values()->all();
        
            $countCandidaturas = 0;
            $countCandidaturasEmAgendamento = 0;
            $countCandidaturasConfirmadas = 0;

            foreach($vagasCandidatura as $candidatura){
                if($candidatura->status != 'CONTRATADO' && $candidatura->status != 'ENTREVISTA CANCELADA' && $candidatura->status != 'RECUSADO'){
                    $countCandidaturas++;
                }
                if($candidatura->status == 'EM AGENDAMENTO'){
                    $countCandidaturasEmAgendamento++;
                }
                if($candidatura->status == 'ENTREVISTA CONFIRMADA'){
                    $countCandidaturasConfirmadas++;
                }
            }

            return Response::json([
                'vagasCandidaturas' => $unique_data,
                'candidaturas'=> $vagasCandidatura,
                'countCandidaturas'=> $countCandidaturas,
                'countCandidaturasEmAgendamento'=>$countCandidaturasEmAgendamento,
                'countCandidaturasConfirmadas' => $countCandidaturasConfirmadas,
            ]);
            
        }
        else{
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $curriculo_id = Curriculo::where('fisicas_id', $fisica_id)->first()->id;
            $count = 0;

            if(Candidatura::where('curriculos_id', $curriculo_id)->exists()){
                $candidatura_id = Candidatura::where('curriculos_id', $curriculo_id)->first()->id;
                $candidaturas_fisica = Candidatura::with(['vaga', 'agenda', 'curriculo'])
                                        ->where('curriculos_id', $curriculo_id)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
            
                return Response::json([
                    'candidaturas' => $candidaturas_fisica,
                    'countCandidaturas' => 1,
                ]);
            }
            else{
                return Response::json([
                    'candidaturas'=>[]
                ]);
            }
            
        } 

    }

    public function store(Request $request)
    {   
        $vaga_id = $request->vagaId;
        $fisicas_id = Fisica::where('user_id', $request->userId)->first()->id;
        $curriculos_id = Curriculo::where('fisicas_id', $fisicas_id)->first()->id;
       
        Candidatura::create([
            'vagas_id' => $vaga_id,
            'curriculos_id' => $curriculos_id,
            'status'=>'AGUARDANDO'
        ]);
    
        $user_id = auth()->user()->id; 
        $user = User::find($user_id);
        $vagas = Vaga::whereNotIn('id', function($q) use ($user){
                $q->from('candidaturas')
                    ->select('vagas_id')
                    ->where('curriculos_id', '=', $user->fisica->curriculo->id);
                })
                ->with('area')
                ->orderBy('created_at', 'desc')
                ->get();
    
        $candidaturas = Candidatura::with(['vaga', 'agenda', 'curriculo'])
                        ->where('curriculos_id', $user->fisica->curriculo->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return Response::json([
            'Candidatura ok',
            'vagas'=>$vagas,
            'candidaturas'=>$candidaturas
         ], 201);
    }

    public function show($id){
        $candidaturas = Vaga::find($id);
    
        return Response::json([
            'vaga'=>$vaga
        ], 201);   
    }

    public function recusaCandidato($id){

        $candidatura_id = $id;
        $candidatura = Candidatura::findOrFail($candidatura_id);
        $candidatura->status = "RECUSADO";
       
        $candidatura->update();
        

        return Response::json([
            'recusou candidato',
            
            'role' => auth()->user()->role
        ]);

    }


    public function destroy($id){

        $candidatura = Candidatura::find($id);
        
        $candidatura->delete();


        return Response::json([
            'deletou candidatura'=> $id,
            'role' => auth()->user()->role
        ]);

    }
    
}
