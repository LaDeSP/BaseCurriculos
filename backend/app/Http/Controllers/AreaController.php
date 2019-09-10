<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Area; 

class AreaController extends Controller
{
    public function store(Request $request)
    {  
            Area::create([
                'tipo'=>$request->input('area')
            ]);

            return Response::json([
                'message'=>'Area cadastrada com sucesso!'
             ], 201); 
       
    }
    
}
