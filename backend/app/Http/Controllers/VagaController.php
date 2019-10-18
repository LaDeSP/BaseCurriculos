<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $vagas_juridica = Vaga::with('area')->where('juridicas_id', $juridica_id)->get();
            return Response::json([
                'vagas' => $vagas_juridica,
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
        $validator = Validator::make($request->all(), VagaController::rules(), VagaController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        $juridicas_id = Juridica::where('user_id', auth()->user()->id)->first()->id;
     

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
            'areas_id' => $request->area,
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
        $validator = Validator::make($request->all(), VagaController::rules(), VagaController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }

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

    public function changeStatus(Request $request){
        Vaga::where('id', $request->vaga_id)->update([
            'status'=>$request->status
        ]);
    
        return Response::json(['mudou status', $request->vaga_id]);
    }

    public function destroy($id)
    {
    
        $vaga = Vaga::find($id);
        $vaga->delete();

        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }
    public function messages(){
        return $messages = [
            'titulo.required' => 'Insira um título!',
            'titulo.max' => 'Insira um título com no máximo 50 caracteres!',
            'local.required' => 'Insira um local!',
            'local.max' => 'Insira local com no máximo 50 caracteres',
            'quantidade.required' => 'Insira uma quantidade!',
            'quantidade.numeric' => 'Insira quantidade apenas com números!',
            'quantidade.gt' => 'Insira quantidade com valor maior que 0!',
            'area.required' => 'Insira uma área!',
            'salario.required' => 'Insira um salário!',
            'salario.numeric' => 'Insira salário apenas com números!',
            'salario.gt' => 'Insira salário com valor maior que 0!',
            'jornada.required' => 'Insira jornada!',
            'jornada.max' => 'Insira jornada com no máximo 50 caracteres!',
            'beneficios.required' => 'Insira os benefícios!',
            'beneficios.max' => 'Insira benefícios com no máximo 500 caracteres!',
            'requisitos.required' => 'Insira os requisitos!',
            'requisitos.max' => 'Insira requisitos com no máximo 500 caracteres!'
        ];
    }

    public function rules(){
        return [
            'titulo' => 'required|max:50',
            'local' => 'required|max:50',
            'quantidade' => 'required|numeric|gt:0',
            'area' => 'required',
            'salario' => 'required|numeric|gt:0',
            'jornada' => 'required|max:50',
            'beneficios' => 'required|max:500',
            'requisitos' => 'required|max:500'
        ];
    }
    
}
