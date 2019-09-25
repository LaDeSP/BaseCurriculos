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
