<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Response;

use App\Vaga;
use App\Juridica;
use App\Area;

class VagaController extends Controller
{

    public function index(){

        $areas = Area::all();
        $vagas = Vaga::with('juridica', 'area')->get();
        $user_id = auth()->user()->id; 
       
        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            return Response::json([
                'areas' => $areas,
                'vagas' => $vagas,
                'auth_jur'=> $juridica_id
            ], 201);   
        }else{
            return Response::json([
                'areas' => $areas,
                'vagas' => $vagas,
                'auth_fis'=>true
            ], 201); 
        }        

    }

    public function store(Request $request)
    {   
        if(!$request->titulo){
            $error[] = 'Insira um titulo!';
        }
        else {
            if(strlen($request->titulo)>50){
                $error[] = 'Insira título com no máximo 50 caracteres!';
            }
        }

        if(!$request->local){
            $error[] = 'Insira um local!';
        }
        else {
            if(strlen($request->local)>50){
                $error[] = 'Insira local com no máximo 50 caracteres!';
            }
        }

        if(!$request->quantidade){
            $error[] = 'Insira a quantidade!';
        }else{
            if (!is_numeric($request->quantidade)){
                $error[] = 'Insira a quantidade apenas com números!';
            }
            else if ($request->quantidade<1){
                $error[] = 'Insira a quantidade com número maior ou igual a 1!';
            }
        }

        if(!$request->area){
            $error[] = 'Insira uma área!';
        }
        
        
        if(!$request->salario){
            $error[] = 'Insira o salário!';
        }
        else{
            if (!is_numeric($request->salario)){
                $error[] = 'Insira o salário apenas com números!';
            }
            else if ($request->salario<1){
                $error[] = 'Insira o salário com número maior ou igual a 1!';
            }
        }

        if(!$request->jornada){
            $error[] = 'Insira a jornada!';
        }
        else{
            if(strlen($request->jornada)>50){
                $error[] = 'Insira jornada com no máximo 50 caracteres!';
            }
        }

        if(!$request->beneficios){
            $error[] = 'Insira benefícios!';
        }
        else{
            if(strlen($request->beneficios)>500){
                $error[] = 'Insira benefícios com no máximo 50 caracteres!';
            }
        }
       
        if(!$request->requisitos){
            $error[] = 'Insira os requisitos!';
        } 
        else{
            if(strlen($request->requisitos)>500){
                $error[] = 'Insira requisitos com no máximo 50 caracteres!';
            }
        }
       
        if(isset($error)){
            return Response::json([
            'error' => $error
            ], 201);
        }
        $juridicas_id = Juridica::where('user_id', $request->user_id)->first()->id;
        $areas_id = $request->area;

        Vaga::create([
            'titulo' => $request->titulo,
            'local' => $request->local,
            'status'=>$request->status,
            'quantidade'=>$request->quantidade,
            'salario' => $request->salario,
            'beneficio' => $request->beneficios,
            'jornada' => $request->jornada,
            'requisito' => $request->requisitos,
            'juridicas_id' => $juridicas_id,
            'areas_id' => $areas_id
        ]);

        return Response::json([
            'message' => 'Vagas Cadastradas'
         ], 201);
    }
 

    public function show($id)
    {
        $vaga = Vaga::find($id);
    
        return Response::json([
            'vaga'=>$vaga
        ], 201);   

    }


    public function update(Request $request, $id)
    {
        Vaga::where('id', $id)->update([
            'titulo' => $request->titulo,
            'quantidade'=>$request->quantidade,
            'local' => $request->local,
            'salario' => $request->salario,
            'beneficio' => $request->beneficios,
            'jornada' => $request->jornada,
            'requisito' => $request->requisitos,
            'areas_id' => $request->area
        ]);

        return Response::json(['area_id', $request->area]);
      
    }

    public function disable(Request $request){
        Vaga::where('id', $request->vaga_id)->update([
            'status'=>'INATIVA'
        ]);
    
        return Response::json(['desativou', $request->vaga_id]);
    }

    public function destroy($id)
    {
    
        $vaga = Vaga::find($id);
        $vaga->delete();

        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }
    
}
