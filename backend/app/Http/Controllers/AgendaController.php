<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Response;
use App\Agenda;
use App\Juridica;
use App\Fisica;
use App\User;
use App\Curriculo;

use App\Candidatura;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;
    
        if(Juridica::where('user_id', $user_id)->exists()){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $agenda =  Agenda::with(['candidatura.vaga', 'candidatura.curriculo.fisica.user'])
                        ->whereHas('candidatura.vaga.juridica', function($query) use ($juridica_id){ 
                            $query->where('id', '=', $juridica_id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
    
           $countAgenda = count($agenda);
           
            return Response::json([
                'agenda' => $agenda,
                'countAgenda' => $countAgenda
             ]);

        }
        else{

            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $agenda =  Agenda::with(['candidatura.vaga', 'candidatura.curriculo.fisica.user'])
                        ->whereHas('candidatura.curriculo.fisica', function($query) use ($fisica_id){ 
                            $query->where('id', '=', $fisica_id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();

            return Response::json([
                'agenda' => $agenda, 
             ]);
        } 
     
    
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), AgendaController::rules(), AgendaController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        } 
        $combinatedDateAndTime = AgendaController::combineDateAndTimeInUniqueVariable($request->data, $request->hora);
        $request->data=$combinatedDateAndTime;
        $validator = Validator::make($request->all(), AgendaController::rule_datahora(), AgendaController::messages());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
           ], 201);
        } 

        $candidatura_id = $request->candidatura_id;
            
        Agenda::create([
            'data'=>$request->data,
            'hora'=>$request->hora,
            'observacao'=>$request->observacao,
            'candidatura_id'=>$candidatura_id
        ]);

        Candidatura::where('id', $candidatura_id)->update(array(
            'status' => 'EM AGENDAMENTO'
        ));

        $user_id = auth()->user()->id;
        $juridica_id = Juridica::where('user_id', $user_id)->first()->id;

        $vagasCandidatura =  Candidatura::whereHas('vaga', function($query) use ($juridica_id){ 
                                $query->where('juridicas_id', '=', $juridica_id)->groupBy('vagas_id');
                             })
                             ->orderBy('created_at', 'desc')
                             ->get();

        $countCandidaturasEmAgendamento = $vagasCandidatura
            ->where('status', 'EM AGENDAMENTO')->count();

        return Response::json([
            'cadastrou agenda',
            'countCandidaturasEmAgendamento'=>$countCandidaturasEmAgendamento,
        ]);
    }

    public function update(Request $request, $id)
    {  
        $agenda_id = Agenda::where('candidatura_id', $request->candidatura_id)->first()->id;
        Agenda::where('id', $agenda_id)->update([
            'data' => $request->data,
            'hora' => $request->hora,
            'observacao' => $request->observacao,
            'contraproposta' => $request->contraproposta,
        ]);

        return Response::json([
            'update agenda'
        ], 201);
    }

    public function confirmAgenda(Request $request){

        $candidatura_id = $request->candidatura_id;

        if($request->contratado == 'CONTRATADO'){
            Candidatura::where('id', $candidatura_id)->update(array(
                'status' => 'CONTRATADO'
            ));
        }
        else{
            Candidatura::where('id', $candidatura_id)->update(array(
                'status' => 'ENTREVISTA CONFIRMADA'
            ));
        }

        $user_id = auth()->user()->id;
        $user_role = auth()->user()->role;
        $candidaturas = [];
        $agenda = [];
        
        if($user_role === 'FISICA'){
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $curriculo_id = Curriculo::where('fisicas_id', $fisica_id)->first()->id;
            $candidaturas = Candidatura::with(['vaga', 'agenda', 'curriculo'])
                            ->where('curriculos_id', $curriculo_id)
                            ->orderBy('created_at', 'desc')
                            ->get();

            $agenda = Agenda::with(['candidatura'])
                        ->where('candidatura_id', $candidatura_id)
                        ->first()
                        ->get();
        }
        else{
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $agenda =  Agenda::with(['candidatura.vaga', 'candidatura.curriculo.fisica.user'])
                        ->whereHas('candidatura.vaga.juridica', function($query) use ($juridica_id){ 
                            $query->where('id', '=', $juridica_id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
        }
        
        if($request->contratado == 'CONTRATADO'){
            return Response::json([
                'agenda' => $agenda,
                'notificacao' => 'Contratado!',
            ]);
        }
        else{
            return Response::json([
                'agenda' => $agenda,
                'candidaturas' => $candidaturas,
            ]);
        }
    }

    public function cancelAgenda(Request $request){

        $candidatura_id = $request->candidatura_id;
        $agenda_id = Agenda::where('candidatura_id', $candidatura_id)->first()->id;
        $observacao = $request->observacao; 

        
        Agenda::where('candidatura_id', $candidatura_id)->update(array(
            'observacao' => $observacao
        ));
        

        Agenda::where('candidatura_id', $candidatura_id)->update(array(
            'contraproposta'=>auth()->user()->role
        ));
        
        if($request->recusa == 'RECUSADO'){
            Candidatura::where('id', $candidatura_id)->update(array(
                'status' => 'RECUSADO'
            ));
        }
        else{
            Candidatura::where('id', $candidatura_id)->update(array(
                'status' => 'ENTREVISTA CANCELADA'
            ));
        }
       
        return Response::json([
            'cancelou entrevista',
            'updateAgenda' => $this->index()->original,
            'role' => auth()->user()->role
        ]);

    }

    public function combineDateAndTimeInUniqueVariable($date, $hour){
        return date('Y-m-d H:i:s', strtotime("$date $hour"));
    }
  
    public function messages(){
        return $messages = [
            'data.required' => 'Insira uma data!',
            'data.after_or_equal' => 'A data-hora deve ser igual ou maior que a data-hora atual.',
            'data.before' => 'A data deve ser realista.',
            'hora.required' => 'Insira uma hora!',
            'observacao.max' => 'Insira observação com no máximo 5000 caracteres!',
            'contraproposta.max' => 'Insira a contraproposta com no máximo 5000 caracteres!',
        ];
    }

    public function rules(){
        return [
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'observacao' => 'max:5000',
            'contraproposta' => 'max:5000',
        ];
    }

    public function rule_datahora(){
        return [
            'data' => 'date|before:2030-01-01 00:00|after_or_equal:'.date('Y-m-d H:i'),
        ];
    }

}
