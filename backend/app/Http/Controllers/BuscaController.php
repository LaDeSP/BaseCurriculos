<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;
use App\Vaga; 

class BuscaController extends Controller
{
    public function buscaVagas($keywords){

        $vagas = Vaga::where('titulo', 'like', '%' . $keywords . '%')->get();


        return response()->json($vagas);
    }
    
}
