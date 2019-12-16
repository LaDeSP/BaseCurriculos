<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Response;
use App\Area;
use App\Fisica;
use App\Curriculo;
use App\Contato;
use App\Endereco;
use App\User;

class CurriculoController extends Controller
{
    public function store(Request $request){
       $validator = Validator::make($request->all(), CurriculoController::rules(), CurriculoController::messages());
         
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }   
        
        $user_id = auth()->user()->id;
        User::where('id', $user_id)->update(['name'=>$request->nome]);
        
        $fisica = Fisica::where('user_id', $user_id)->first()->id;
        
        $end_id = Endereco::insertGetId([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
            'pais' => $request->pais,
            'cep' => $request->cep
        ]);
        
        $con_id = Contato::insertGetId([
            'celular' => $request->celular,
            'fixo' => $request->fixo,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'site' => $request->site,
            'outraRede' => $request->outraRede
        ]);

        Fisica::where('user_id', $user_id)
        ->update(array(
            'data_nascimento' => $request->nascimento,
            'genero'  => $request->genero,
            'estado_civil' => $request->estadoCivil,
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id
        ));

        Curriculo::create([
            'objetivos' => $request->objetivos,
            'areas_id' => $request->area,
            'pretensao' => $request->pretensao,
            'qualificacoes' => $request->qualificacoes,
            'historicoProfissional' => $request->historicoProfissional,
            'escolaridade' => $request->escolaridade,
            'fisicas_id' => Fisica::where('user_id', $user_id)->first()->id
        ]);
        
        return Response::json([
        'PORRAAAAAA'=>auth()->user()
        ], 201);
    }

    public function show($id)
    {  
        $fisicas_id = Fisica::where('user_id', $id)->first()->id;
        if($area_id = Curriculo::where('fisicas_id', $fisicas_id)->first()->areas_id){
            $area_id = Curriculo::where('fisicas_id', $fisicas_id)->first()->areas_id;
        }
  
        $area = Area::where('id', $area_id)->first()->tipo;
        $fisica = Fisica::with(['contato', 'endereco', 'user'])->where('user_id', $id)->orderBy('created_at', 'desc')->get();

        $curriculo = Curriculo::with(['fisica'])->where('fisicas_id', $fisicas_id)->orderBy('created_at', 'desc')->get();
        
        return Response::json([
           'curriculo' => $curriculo,
           'fisica' => $fisica,
           'area'=> $area,
           'area_id' => $area_id
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), CurriculoController::rules(), CurriculoController::messages());
       
        if ($validator->fails()) {
             return Response::json([
                'error' => $validator->messages()
            ], 201);
        }   

        $end_id = Fisica::where('user_id', $id)->value('enderecos_id');
        $con_id = Fisica::where('user_id', $id)->value('contatos_id');

        User::where('id', $id)->update(['name'=>$request->nome]);

        Endereco::where('id', $end_id)->update([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
            'pais' => $request->pais,
            'cep' => $request->cep
        ]);

        Contato::where('id', $con_id)->update([
            'celular' => $request->celular,
            'fixo' => $request->fixo,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'site' => $request->site,
            'outraRede' => $request->outraRede
        ]);

        Fisica::where('user_id', $id)->update(array(
                'data_nascimento' => $request->nascimento,
                'genero'  => $request->genero,
                'estado_civil' => $request->estadoCivil
            ));
        
        $fisicas_id = Fisica::where('user_id', $id)->first()->id;

        Curriculo::where('fisicas_id', $fisicas_id)->update([
            'objetivos' => $request->objetivos,
            'areas_id' => $request->area,
            'pretensao' => $request->pretensao,
            'qualificacoes' => $request->qualificacoes,
            'historicoProfissional' => $request->historicoProfissional,
            'escolaridade' => $request->escolaridade
        ]);

        return Response::json([
            'SEI LA MAN'=>$request->input('user_id')
           ], 201);
      
      
    }
    
    public function rules(){
        $estadoCivil = "Solteiro(a),Casado(a),Separado(a),Viúvo(a)";
        $estado = "AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO";
        $escolaridade="Ensino Fundamental(Incompleto),Ensino Fundamental(Cursando),Ensino Fundamental(Completo),Ensino Médio(Incompleto),Ensino Médio(Completo),Ensino Superior(Incompleto),Ensino Superior(Cursando),Ensino Superior(Completo),Pós-Graduação(Especialização),Pós-Graduação(Mestrado),Pós-Graduação(Doutorado)";
        $pais="África do Sul,Albânia,Alemanha,Andorra,Angola,Anguilla,Antigua,Arábia Saudita,Argentina,Armênia,Aruba,Austrália,Áustria,Azerbaijão,Bahamas,Bahrein,Bangladesh,Barbados,Bélgica,Benin,Bermudas,Botsuana,Brasil,Brunei,Bulgária,Burkina Fasso,Botão,Cabo Verde,Camarões,Camboja,Canadá,Cazaquistão,Chade,Chile,China,Cidade do Vaticano,Colômbia,Congo,Coréia do Sul,Costa do Marfim,Costa Rica,Croácia,Dinamarca,Djibuti,Dominica,EUA,Egito,El Salvador,Emirados Árabes,Equador,Eritréia,Escócia,Eslováquia,Eslovênia,Espanha,Estônia,Etiópia,Fiji,Filipinas,Finlândia,França,Gabão,Gâmbia,Gana,Geórgia,Gibraltar,Granada,Grécia,Guadalupe,Guam,Guatemala,Guiana,Guiana Francesa,Guiné-bissau,Haiti,Holanda,Honduras,Hong Kong,Hungria,Iêmen,Ilhas Cayman,Ilhas Cook,Ilhas Curaçao,Ilhas Marshall,Ilhas Turks & Caicos,Ilhas Virgens (brit.),Ilhas Virgens(amer.),Ilhas Wallis e Futuna,Índia,Indonésia,Inglaterra,Irlanda,Islândia,Israel,Itália,Jamaica,Japão,Jordânia,Kuwait,Latvia,Líbano,Liechtenstein,Lituânia,Luxemburgo,Macau,Macedônia,Madagascar,Malásia,Malaui,Mali,Malta,Marrocos,Martinica,Mauritânia,Mauritius,México,Moldova,Mônaco,Montserrat,Nepal,Nicarágua,Niger,Nigéria,Noruega,Nova Caledônia,Nova Zelândia,Omã,Palau,Panamá,Papua-nova Guiné,Paquistão,Peru,Polinésia Francesa,Polônia,Porto Rico,Portugal,Qatar,Quênia,Rep. Dominicana,Rep. Tcheca,Reunion,Romênia,Ruanda,Rússia,Saipan,Samoa Americana,Senegal,Serra Leone,Seychelles,Singapura,Síria,Sri Lanka,St. Kitts & Nevis,St. Lúcia,St. Vincent,Sudão,Suécia,Suiça,Suriname,Tailândia,Tanzânia,Togo,Trinidad & Tobago,Tunísia,Tunísia,Turquia,Ucrânia,Uganda,Uruguai,Venezuela,Vietnã,Zaire,Zâmbia,Zimbábue";
        return [
            'nome' => 'required|max:250',
            'nascimento' => 'required|date', 
            'estadoCivil' => 'required|in:'.$estadoCivil,
            'genero' => 'required', /*validar lista*/
            'linkedin' => 'max:250',
            'facebook' => 'max:250',
            'twitter' => 'max:250',
            'site' => 'max:250',
            'outraRede' => 'max:250',
            'emailAlt' => 'email|max:250',
            'pais' => 'required|in:'.$pais,
            'estado' => 'required|in:'.$estado,
            'fixo' => 'nullable|telefone_com_ddd',
            'celular' => 'required|celular_com_ddd',
            'rua' => 'required|max:250',
            'numero' => 'max:250',
            'complemento' => 'max:250',
            'bairro' => 'required|max:250',
            'cidade' => 'required|max:250',
            'cep'=> 'required|digits:8',
            'objetivos'=> 'required|max:5000',
            'area' => 'required|exists:areas,id',
            'pretensao' => 'required|numeric|min:1|max:1000000',
            'escolaridade' => 'required|in:'.$escolaridade,
            'qualificacoes' => 'required|max:5000',
            'historicoProfissional' => 'required|max:5000'
        ];
    }

    public function messages(){
        return $messages = [
            'nome.required' => 'Insira um nome!',
            'nome.max' => 'Insira nome com no máximo 250 caracteres.',
            'nascimento.required' => 'Insira sua data de nascimento!',
            'estadoCivil.required' => 'Insira seu estado civil!',
            'estadoCivil.in' => 'Insira um estado civil válido!',
            'genero.required' => 'Insira seu gênero!',
            'linkedin.max' => 'Insira linkedin com no máximo 250 caracteres.',
            'facebook.max' => 'Insira facebook com no máximo 250 caracteres.',
            'twitter.max' => 'Insira twitter com no máximo 250 caracteres.',
            'site.max' => 'Insira site com no máximo 250 caracteres.',
            'outraRede.max' => 'Insira outra rede com no máximo 250 caracteres.',
            'estado.required' => 'Selecione um estado!',
            'estado.in' => 'Selecione um estado válido!',
            'fixo.required' => 'Insira um número fixo!',
            'fixo.telefone_com_ddd' => 'Número fixo inválido!',
            'celular.required' => 'Insira um número de celular!',
            'celular.celular_com_ddd' => 'Número de celular inválido!',
            'rua.required' => 'Insira uma rua!',
            'rua.max' => 'Insira rua com no máximo 250 caracteres.',
            'numero.max' => 'Insira número com no máximo 250 caracteres.',
            'complemento.max' => 'Insira complemento com no máximo 5000 caracteres.',
            'bairro.required' => 'Insira um bairro!',
            'bairro.max' => 'Insira bairro com no máximo 250 caracteres.',
            'cidade.required' => 'Insira uma cidade!',
            'cidade.max' => 'Insira cidade com no máximo 250 caracteres.',
            'cep.required' => 'Insira um CEP!',
            'cep.digits' => 'Insira CEP válido!',
            'objetivos.required' => 'Insira seus objetivos!',
            'objetivos.max' => 'Insira seus objetivos com no máximo 5000 caracteres!',
            'area.required' => 'Insira sua área!',
            'area.exists' => 'Insira área válida!',
            'pretensao.required' => 'Insira sua pretensão salarial!',
            'pretensao.numeric' => 'Insira sua pretensão salarial apenas com números!',
            'pretensao.min' => 'Insira pretensão salarial com valor maior que 0!',
            'pretensao.max' => 'Insira pretensão salarial com valor máximo de 1000000!',
            'escolaridade.required' => 'Insira sua escolaridade!',
            'qualificacoes.required' => 'Insira suas qualificações!',
            'qualificacoes.max' => 'Insira suas qualificações com no máximo 5000 caracteres!',
            'historicoProfissional.required' => 'Insira seu histórico!',
            'historicoProfissional.max' => 'Insira seu histórifo profissional com no máximo 5000 caracteres!'
        ];
    }   

   

}
