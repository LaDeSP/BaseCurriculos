<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Response;
use App\Agenda;
use App\Juridica;
use App\Fisica;
use App\User;

use App\Candidatura;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function teste (){

        $agenda =  Agenda::with(['candidatura.vaga', 'curriculo.fisica.user'])
        ->whereHas('candidatura.vaga.juridica', function($query){ 
            $query->where('id', '=', 2);
        })->get();
    
        dd($agenda);
       // dd($user->juridica->vaga[0]->candidatura[0]->agenda);
    }

    public function index(){

        $user_id = auth()->user()->id;
    
        if(Juridica::where('user_id', $user_id)->exists()){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $agenda =  Agenda::with(['candidatura.vaga', 'candidatura.curriculo.fisica.user'])
            ->whereHas('candidatura.vaga.juridica', function($query) use ($juridica_id){ 
                $query->where('id', '=', $juridica_id);
            })->orderBy('created_at')->get();
    
          //  $collection = collect($vagasCandidatura);
           // $unique = $collection->unique('vagas_id');
           // $unique_data = $unique->values()->all();
    
            return Response::json([
                'agenda' => $agenda,
             ]);

        }else{

            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            $agenda =  Agenda::with(['candidatura.vaga', 'candidatura.curriculo.fisica.user'])
            ->whereHas('candidatura.curriculo.fisica', function($query) use ($fisica_id){ 
                $query->where('id', '=', $fisica_id);
            })->orderBy('created_at')->get();

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

        if(Agenda::where('candidatura_id', $candidatura_id)->exists()){
            
            Agenda::where('candidatura_id', $candidatura_id)->update(array(
                'data'=>$request->data,
                'hora'=>$request->hora,
                'observacao'=>$request->observacao,
                'contraproposta'=>$request->contraproposta,
            ));

            Candidatura::where('id', $candidatura_id)->update(array(
                'status' => 'EM AGENDAMENTO'
            ));

            
            $user_id = auth()->user()->id;
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;

            $vagasCandidatura =  Candidatura::whereHas('vaga', function($query) use ($juridica_id){ 
                $query->where('juridicas_id', '=', $juridica_id)->groupBy('vagas_id');
            })->get();

            $countCandidaturasAguardando = $vagasCandidatura
                ->where('status', 'EM AGENDAMENTO')->count();

            return Response::json([
                'agendaExiste'=> true,
                'countCandidaturasAguardando'=>$countCandidaturasAguardando,
            ]);

        }else{
            Agenda::create([
                'data'=>$request->data,
                'hora'=>$request->hora,
                'observacao'=>$request->observacao,
                'contraproposta'=>$request->contraproposta,
                'candidatura_id'=>$candidatura_id
             ]);
     
             Candidatura::where('id', $candidatura_id)->update(array(
                 'status' => 'EM AGENDAMENTO'
             ));
     
             return Response::json([
                'cadastrou agenda'
             ]);
        }
                 
    }

    public function update(Request $request, $id)
    {
     //   $validator = Validator::make($request->all(), CurriculoController::rules(), CurriculoController::messages());
         
    /*  if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }   
    */
       
        Agenda::where('id', $request->update_id)->update([
            'data' => $request->data,
            'hora' => $request->hora,
            'observacao' => $request->observacao,
        ]);

        return Response::json([
            'update agenda'=>$request->update_id
           ], 201);
      
      
    }

    public function destroy($id){

        $candidatura_id = Agenda::where('id', $id)->first()->candidatura_id;
        Candidatura::where('id', $candidatura_id)->update(array(
            'status' => 'CANCELADA'
        ));

        return Response::json([
            'cancelou entrevista'
        ]);

    }

    public function combineDateAndTimeInUniqueVariable($date, $hour){
        return date('Y-m-d H:i:s', strtotime("$date $hour"));
    }
  
    public function messages(){
        return $messages = [
            'data.required' => 'Insira uma data!',
            'data.after_or_equal' => 'A data-hora devem ser igual ou maior que a data-hora atual.',
            'data.before' => 'A data deve ser realista.',
            'hora.required' => 'Insira uma hora!',
            'observacao.max' => 'Insira observação com no máximo 500 caracteres!',
            'contraproposta.max' => 'Insira a contraproposta com no máximo 500 caracteres!',
        ];
    }

    public function rules(){
        return [
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'observacao' => 'max:500',
            'contraproposta' => 'max:500',
        ];
    }

    public function rule_datahora(){
        return [
            'data' => 'date|before:2030-01-01 00:00|after_or_equal:'.date('Y-m-d H:i'),
        ];
    }

}
