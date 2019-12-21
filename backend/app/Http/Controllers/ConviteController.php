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
use App\Convite;

class ConviteController extends Controller
{
    public function store(Request $request)
    {   
        $vaga_id = $request->vaga_id;
        $curriculo_id = $request->curriculo_id;
      //  $quantVaga = Vaga::where('id', $vaga_id)->first()->quantidade;
       // $quantCandidato = Candidatura::where('vagas_id', $vaga_id)->count();

//        if($quantCandidato < $quantVaga){
        $result = Convite::where('vagas_id', $vaga_id)->where('curriculos_id', $curriculo_id)->where('resposta', 'AGUARDANDO')->exists();
        $resultCandidatura = Candidatura::where('vagas_id', $vaga_id)->where('curriculos_id', $curriculo_id)->where(function ($query) {
                                $query->where('status', "EM AGENDAMENTO")
                                    ->orWhere('status', "AGUARDANDO")
                                    ->orWhere('status', "ENTREVISTA CONFIRMADA");
                                    })->exists();
        if($result){
            $errorConvite[] = "Você já convidou essa pessoa.";
            $error[] = $errorConvite;
            return Response::json([
                'error' => $error
            ], 201);
        }

        if($resultCandidatura){
            $errorCandidatura[] = "Essa pessoa está candidata nessa vaga.";
            $error[] = $errorCandidatura;
            return Response::json([
                'error' => $error
            ], 201);
        }
            Convite::create([
                'vagas_id' => $vaga_id,
                'curriculos_id' => $curriculo_id,
                'resposta'=>'AGUARDANDO'
            ]);//Qualquer coisa colocar algo ligando a candidatura
  //      }else{
    //        Vaga::where('id', $vaga_id)
      //      ->update([
        //        'status' => 'INATIVA'
         //   ]);
      //}
       /*$user_id = auth()->user()->id; 
      $user = User::find($user_id);
      $vagas = Vaga::whereNotIn('id', function($q) use ($user){
        $q->from('candidaturas')
            ->select('vagas_id')
            ->where('curriculos_id', '=', $user->fisica->curriculo->id);
        })
        ->with('area')->get();
    
        $candidaturas = Candidatura::with(['vaga', 'agenda', 'curriculo'])
        ->where('curriculos_id', $user->fisica->curriculo->id)->get();*/

        return Response::json([
            'convite ok',

        ], 201);
    }

    public function getConvites(){
        $user_id = auth()->user();
        if($user_id->role == 'FISICA'){
            $curriculo = $user_id->fisica->curriculo;

            $convites = Convite::with(['vaga.area', 'vaga'])->where('curriculos_id', $curriculo->id)->where('resposta', 'AGUARDANDO')->orderBy('created_at', 'desc')->get();

            return Response::json([
                'convites' => $convites,
                'countConvites' => count($convites)
            ], 201);
        }
        else{
            $juridica = $user_id->juridica;
            $juridica_id = $juridica->id;
            $vagasConvites =  Convite::with(['vaga', 'curriculo.area', 'curriculo.fisica.contato', 'curriculo.fisica.user'])
                ->whereHas('vaga', function($query) use ($juridica_id){ 
                    $query->where('juridicas_id', '=', $juridica_id)->groupBy('vagas_id');
                })->orderBy('created_at', 'desc')->get();

            $collection = collect($vagasConvites);
            $unique = $collection->unique('vagas_id');
            $unique_data = $unique->values()->all();
        
            $countConvites = 0;
            $countConvitesAguardando = 0;
            $countConvitesConfirmados = 0;
            $countConvitesNegados = 0;

            foreach($vagasConvites as $convite){
                if($convite){
                    $countConvites++;
                }
                if($convite->resposta == 'AGUARDANDO'){
                    $countConvitesAguardando++;
                }
                if($convite->resposta == 'ACEITOU'){
                    $countConvitesConfirmados++;
                }
                if($convite->resposta == 'RECUSOU'){
                    $countConvitesNegados++;
                }
            }

            return Response::json([
                'vagasConvites' => $unique_data,
                'convites'=> $vagasConvites,
                'countConvites'=> $countConvites,
                'countConvitesAguardando'=>$countConvitesAguardando,
                'countConvitesConfirmados' => $countConvitesConfirmados,
                'countConvitesNegados' => $countConvitesNegados
            ]);


        }

    }

    public function respostaConvite(Request $request){
        $vaga_id = $request->vaga_id;
        $user_id = auth()->user();
        $curriculo = $user_id->fisica->curriculo;

        $convite = Convite::where('curriculos_id', $curriculo->id)->where('vagas_id', $vaga_id)->where('resposta', 'AGUARDANDO')->first();

        if(!$convite){
            return Response::json([
                'error' => 'Usuário não possui convites.'
            ], 201);
        }

        if($request->resposta=='RECUSOU'){
            $convite->resposta='RECUSOU';
            $convite->update();

            $convites=ConviteController::getConvites();
            
            return Response::json([
                'convites' => $convites,
                'message' => 'Você recusou o convite recusado.'
            ], 201);
        }

        else if($request->resposta=='ACEITOU'){
            $convite->resposta='ACEITOU';
            $convite->update();

            Candidatura::create([
                'vagas_id' => $vaga_id,
                'curriculos_id' => $curriculo->id,
                'status'=>'AGUARDANDO'
            ]);

            $convites=ConviteController::getConvites();
            
            return Response::json([
                'convites' => $convites,
                'message' => 'Sua candidatura foi criada.'
            ], 201);
        }

        return Response::json([
            'a'
        ], 201);
    }

    public function cancelarConvite(Request $request){
        $convite = Convite::findOrFail($request->convite_id);
       
        $convite->resposta = "CANCELADO";
        $convite->update();
        $convites=ConviteController::getConvites();
            
        return Response::json([
            'convites' => $convites,
            'message' => 'Você cancelou o convite..'
        ], 201);
    }
}
