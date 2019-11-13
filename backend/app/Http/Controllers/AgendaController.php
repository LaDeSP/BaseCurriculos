<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Response;
use App\Agenda;
use App\User;

use App\Candidatura;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function teste (){
        $user = User::findOrFail(3);
        
        dd($user->juridica->vaga[0]->candidatura[0]->agenda);
    }

    public function index(){

      
    
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), AgendaController::rules(), AgendaController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }   
                 
        Agenda::create([
           'data'=>$request->data,
           'hora'=>$request->hora,
           'observacao'=>$request->observacao,
           'contraproposta'=>$request->contraproposta,
           'candidatura_id'=>$request->candidatura_id
        ]);

        Candidatura::where('id', $request->candidatura_id)->update(array(
            'status' => 'EM AGENDAMENTO'
        ));

        return Response::json([
           'cadastrou agenda'
        ]);
    }
  
    public function messages(){
        return $messages = [
            'data.required' => 'Insira uma data!',
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
}
