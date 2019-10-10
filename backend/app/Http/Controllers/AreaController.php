<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;
use App\Area; 

class AreaController extends Controller
{
    public function index(){

        $areas = Area::all();
        
            return Response::json([
                'areas' => $areas,
            ], 201);          

    }

    public function store(Request $request)
    {  
            Area::create([
                'tipo'=>$request->input('area')
            ]);

            return Response::json([
                'area cadastrada'
             ], 201); 
       
    }
    
}
