<?php

namespace App\Http\Controllers;

use Response;
use App\Agenda;
use App\Candidatura;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
  
    public function store(Request $request)
    {   
        if(!$request->data){
            $error[] = 'Insira uma data!';
        }

        if(!$request->hora){
            $error[] = 'Insira uma hora!';
        }


        if($request->observacao){
            if(strlen($request->observacao)>500){
                $error[] = 'Insira suas observações com no máximo 500 caracteres!';
            }
        }
        
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }      
                 
        Agenda::create([
           'data'=>$request->data,
           'hora'=>$request->hora,
           'observacao'=>$request->observacao,
           'candidatura_id'=>$request->candidatura_id
        ]);

        Candidatura::where('id', $request->candidatura_id)->update(array(
            'status' => 'EM AGENDAMENTO'
        ));

        return Response::json([
           'cadastrou agenda'
        ]);
    }

  
    public function show(Agenda $agenda)
    {
        //
    }
   
    public function update(Request $request, Agenda $agenda)
    {
        //
    }

   
    public function destroy(Agenda $agenda)
    {
        //
    }
}
