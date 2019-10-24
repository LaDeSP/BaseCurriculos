<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Response;

use App\Fisica;
use App\Curriculo;
use App\Vaga;
use App\Juridica;
use App\Area;
use App\User;

class VagaController extends Controller
{

    public function index(){

        $areas = Area::all();
        $user_id = auth()->user()->id; 
        $user = User::find($user_id);
       
        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $vagas_juridica = Vaga::with('area')->where('juridicas_id', $juridica_id)->get();
            return Response::json([
                'vagas' => $vagas_juridica,
            ], 201);   
        }else{
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            if(Curriculo::where('fisicas_id', $fisica_id)->exists()){
                $vagas = Vaga::whereNotIn('id', function($q) use ($user){
                    $q->from('candidaturas')
                        ->select('vagas_id')
                        ->where('curriculos_id', '=', $user->fisica->curriculo->id);
                    })
                    ->with('area')->get();              
            }else{
                $vagas = Vaga::with('area')->get();
            }
           
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
            'cargo' => $request->cargo,
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
            'cargo' => $request->cargo,
            'salario' => $request->salario,
            'beneficio' => $request->beneficios,
            'jornada' => $request->jornada,
            'requisito' => $request->requisitos,
            'areas_id' => $request->area
        ]);

        return Response::json(['Update ok']);
      
    }

    public function changeStatus(Request $request){
        Vaga::where('id', $request->vaga_id)->update([
            'status'=>$request->status
        ]);

      //  $vagaChanged = Vaga::with('juridica', 'area')
            //->where('id', $request->vaga_id)
       //     ->get();

       $juridica_id = Juridica::where('user_id', auth()->user()->id)->first()->id;
       $vagaChanged = Vaga::with('area')->where('juridicas_id', $juridica_id)->get();
    
        return Response::json([
            'mudou status',
            'vagaChanged' => $vagaChanged
        ]);
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
            'cargo.required' => 'Insira um cargo!',
            'cargo.max' => 'Insira cargo com no máximo 50 caracteres',
            'quantidade.required' => 'Insira uma quantidade!',
            'quantidade.numeric' => 'Insira quantidade apenas com números!',
            'quantidade.min' => 'Insira quantidade com valor maior que 0!',
            'area.required' => 'Insira uma área!',
            'salario.required' => 'Insira um salário!',
            'salario.numeric' => 'Insira salário apenas com números!',
            'salario.min' => 'Insira salário com valor maior que 0!',
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
            'cargo' => 'required|max:50',
            'quantidade' => 'required|numeric|min:1|max:1000000',
            'area' => 'required|exists:areas,id',
            'salario' => 'required|numeric|min:1|max:1000000',
            'jornada' => 'required|max:50',
            'beneficios' => 'required|max:500',
            'requisitos' => 'required|max:500'
        ];
    }
    
}
