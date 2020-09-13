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
use App\Candidatura;

class VagaController extends Controller
{
    
    public function index(){

        $areas = Area::all();
        $user_id = auth()->user()->id; 
        $user = User::find($user_id);
       
        if(auth()->user()->role === 'JURIDICA'){
            $juridica_id = Juridica::where('user_id', $user_id)->first()->id;
            $vagasJuridica = Vaga::with('area')
                                ->where('juridicas_id', $juridica_id)
                                ->orderBy('created_at')
                                ->get();
           
            $countVagas = Vaga::where('juridicas_id', $juridica_id)
                          ->where('status', 'ATIVA')
                          ->get()
                          ->count();
           
            return Response::json([
                'vagas' => $vagasJuridica,
                'countVagas'=>$countVagas
            ], 201);   

        }
        else{
            $fisica_id = Fisica::where('user_id', $user_id)->first()->id;
            if(Curriculo::where('fisicas_id', $fisica_id)->exists()){
                $vagas = Vaga::whereNotIn('id', function($q) use ($user){
                    $q->from('candidaturas')
                        ->select('vagas_id')
                        ->where('curriculos_id', '=', $user->fisica->curriculo->id);
                    })
                    ->with('area')
                    ->orderBy('created_at', 'desc')
                    ->get();              
            }
            else{
                $vagas = Vaga::with('area')->orderBy('created_at', 'desc')->get();
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
            'descricao' => $request->descricao,
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
            'descricao' => $request->descricao,
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
        
        $status = $request->status;
        $vaga_id = $request->vaga_id;
        $quantidadeVaga = Vaga::where('id', $vaga_id)->first()->quantidade;
        
        if($status == 'ATIVA'){

            if($quantidadeContratados = Candidatura::where('vagas_id', $vaga_id)->where('status', 'CONTRATADO')->count()){
                
                if($quantidadeVaga == $quantidadeContratados){
                    return response::json([
                        'notificacao' => 'O limite está cheio. 
                        Aumente a quantidade da vaga para ativá-la novamente.'
                    ]);
                }
                else{
                    Vaga::where('id', $vaga_id)->update([
                        'status'=>$status
                    ]);
                }
                
            }
            else{
                
                Vaga::where('id', $vaga_id)->update([
                    'status'=>$status
                ]);
            }
           
        }
        else{
            Vaga::where('id', $vaga_id)->update([
                'status'=>$status
            ]);
        }

        $juridica_id = Juridica::where('user_id', auth()->user()->id)->first()->id;
        $vagaChanged = Vaga::with('area')->where('juridicas_id', $juridica_id)->orderBy('created_at', 'desc')->get();
    
        return Response::json([
            'vagaChanged' => $vagaChanged
        ]);
    }

    public function destroy($id)
    {
        $vaga = Vaga::find($id);
        $vaga->delete();

        return Response::json([
            'updatedVagas'=>$this->index()->original
        ], 201);
    }
    
    public function messages(){
        return $messages = [
            'titulo.required' => 'Insira um título!',
            'titulo.max' => 'Insira um título com no máximo 250 caracteres!',
            'cargo.required' => 'Insira um cargo!',
            'cargo.max' => 'Insira cargo com no máximo 250 caracteres',
            'quantidade.required' => 'Insira uma quantidade!',
            'quantidade.numeric' => 'Insira quantidade apenas com números!',
            'quantidade.min' => 'Insira quantidade com valor maior que 0!',
            'area.required' => 'Insira uma área!',
            'salario.required' => 'Insira um salário!',
            'salario.numeric' => 'Insira salário apenas com números!',
            'salario.min' => 'Insira salário com valor maior que 0!',
            'salario.max' => 'Salário deve ter no máximo 250 dígitos!',
            'jornada.required' => 'Insira jornada!',
            'jornada.max' => 'Insira jornada com no máximo 250 caracteres!',
            'beneficios.required' => 'Insira os benefícios!',
            'beneficios.max' => 'Insira benefícios com no máximo 5000 caracteres!',
            'requisitos.required' => 'Insira os requisitos!',
            'requisitos.max' => 'Insira requisitos com no máximo 5000 caracteres!'
        ];
    }

    public function rules(){
        return [
            'titulo' => 'required|max:250',
            'descricao' => 'required|max:5000',
            'cargo' => 'required|max:250',
            'quantidade' => 'required|numeric|min:1|max:1000000',
            'area' => 'required|exists:areas,id',
            'salario' => 'max:250',
            'jornada' => 'required|max:250',
            'beneficios' => 'required|max:5000',
            'requisitos' => 'required|max:5000'
        ];
    }
    
}
