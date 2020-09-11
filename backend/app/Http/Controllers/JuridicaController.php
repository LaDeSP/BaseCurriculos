<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Response;

use App\Traits\UserTrait;
use App\Juridica;
use App\Contato;
use App\Endereco;
use App\User;
use JWTAuth;

class JuridicaController extends Controller
{
    use UserTrait;
   
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), JuridicaController::rules_basic(), JuridicaController::messages_basic());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
            ], 201);
        }
        $this->register($request);
        
        $pjuridica = new Juridica();
        $cnpj = $pjuridica->cnpj = $request->input('cnpj');
        $ehPatrocinador = $pjuridica->ehPatrocinador = $request->input('ehPatrocinador');
        $areas_id = $pjuridica->areas_id = $request->input('area');
        $email = $request->input('email');
        $id = User::where('email', $email)->first()->id;
        $pjuridica->user_id = $id;

        $pjuridica->save();

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
       
        return Response::json([
            'token'=> $token,
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'user'=> auth()->user(),
            'foto'=> "http://localhost:8000/anon.jpg",
            'message' => 'Pessoa Jurídica cadastrada com sucesso!'
        ], 201); 
    }

    public function addData(Request $request){
        $validator = Validator::make($request->all(), JuridicaController::rules_addData(), JuridicaController::messages_addData());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
            ], 201);
        }

       $user_id = auth()->user()->id;
       User::where('id', $user_id)->update(['name'=>$request->nome]);

       $juridica = Juridica::where('user_id', $user_id)->first()->id;
       
       $con_id = Contato::insertGetId([
            'celular' => $request->celular,
            'fixo' => $request->fixo,
            'linkedin' => $request->linkedin,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'site' => $request->site,
        ]);

        $end_id = Endereco::insertGetId([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
            'cep' => $request->cep,
        ]);
        
        Juridica::where('user_id', $user_id)->update(array(
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id
        ));
        
        return Response::json([
           'username'=>$request->nome
        ], 201);

    }

    public function show($id)
    {
        $juridica = Juridica::with(['contato', 'endereco', 'user'])
                    ->where('user_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return Response::json([
            'juridica' => $juridica
        ], 201);
    }

    public function updateDadosCadastroJuridica (Request $request){
        $user_id = auth()->user()->id; 
        $user = User::findOrFail($user_id);
        $juridica = $user->juridica;
        
        $validator = Validator::make($request->all(), JuridicaController::rules_edit($user->id, $juridica->id), JuridicaController::messages_basic());
        
        if ($validator->fails()) {
            return Response::json([
                'error' => $validator->messages()
            ], 201);
        }
        
        $error = [];
        if($request->newPassword){
            if(!$request->password){
                $errorSenha[] = "Insira senha atual.";
                $error[] = $errorSenha;
                return Response::json([
                    'error' => $error
                ], 201);
            }
            if(!Hash::check($request->password, $user->password)){
                $errorSenha[] = "Senha atual errada.";
                $error[] = $errorSenha;
                return Response::json([
                    'error' => $error
                ], 201);
            }
            $user->password = Hash::make($request->newPassword);
        }
        $user->email = $request->email;
        $juridica->cnpj = $request->cnpj;
        
        $user->update();
        $juridica->update();
        return Response::json([
            'message'=>'Pessoa jurídica atualizada com sucesso!',
            'cnpj'=>$juridica->cnpj,
            'email'=>$user->email,
        ], 201); 
    }

    public function getJuridicaPatrocinadoras()
    {
        $juridicas = Juridica::with(['user.foto', 'endereco'])
                    ->where('ehPatrocinador', '1')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return Response::json([
            'juridicaPatrocinadoras'=>$juridicas
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $end_id = Juridica::where('user_id', $id)->value('enderecos_id');
        $con_id = Juridica::where('user_id', $id)->value('contatos_id');

        User::where('id', $id)->update(['name'=>$request->nome]);
        
        $validator = Validator::make($request->all(), JuridicaController::rules_addData(), JuridicaController::messages_addData());
        if ($validator->fails()) {
            return Response::json([
               'error' => $validator->messages()
           ], 201);
        }

        Endereco::where('id', $end_id)->update([
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'complemento' => $request->complemento,
            'numero' => $request->numero,
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

        Juridica::where('user_id', $id)->update(array(
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id
        ));
    
        return Response::json([
            'Dados editados com sucesso!', 
            'updated'=>$this->show($id)->original
        ], 200);
        
      
    }
    
    public function messages_basic(){
        return $messages = [
            'name.required' => 'Insira um nome!',
            'name.max' => 'Insira nome com no máximo 50 caracteres',
            'area.required' => 'Selecione uma área.',
            'area.exists' => 'Selecione uma área válida.',
            'email.required' => 'Insira um email!',
            'email.email' => 'Insira um email válido!',
            'email.unique' => 'Email inserido já existe!',
            'password.required' => 'Insira uma senha!',
            'password.min' => 'Senha tem que ter no mínimo 8 caracteres!',
            'password.max' => 'Senha tem que ter no máximo 30 caracteres!',
            'cpf.required' => 'Insira um CPF!',
            'cpf.cpf' => 'Insira um CPF válido!',
            'cpf.unique' => 'CPF inserido já foi cadastrado.',
            'cnpj.required' => 'Insira um CNPJ!',
            'cnpj.cnpj' => 'Insira um CNPJ válido!',
            'cnpj.unique' => 'CNPJ inserido já foi cadastrado.'
        ];
    }

    public function rules_basic(){
        return [
           
            'name' => 'required|max:250',
            'area' => 'required|exists:areas,id',
            'email' => 'required|max:50|email|unique:users,email',
            'password' => 'required|min:8|max:30',
            'cnpj' => 'required|cnpj|unique:juridicas,cnpj'
        ];
    }
    public function messages_addData(){
        return $messages = [
            'linkedin.max' => 'Insira linkedin com no máximo 50 caracteres.',
            'facebook.max' => 'Insira facebook com no máximo 50 caracteres.',
            'twitter.max' => 'Insira twitter com no máximo 50 caracteres.',
            'site.max' => 'Insira site com no máximo 50 caracteres.',
            'outraRede.max' => 'Insira outra rede com no máximo 50 caracteres.',
            'estado.required' => 'Selecione um estado!',
            'estado.in' => 'Selecione um estado válido!',
            'fixo.required' => 'Insira um número fixo!',
            'fixo.telefone_com_ddd' => 'Número fixo inválido!',
            'celular.required' => 'Insira um número de celular!',
            'celular.celular_com_ddd' => 'Número de celular inválido!',
            'rua.required' => 'Insira uma rua!',
            'rua.max' => 'Insira rua com no máximo 50 caracteres.',
            'numero.max' => 'Insira número com no máximo 50 caracteres.',
            'complemento.max' => 'Insira complemento com no máximo 500 caracteres.',
            'bairro.required' => 'Insira um bairro!',
            'bairro.max' => 'Insira bairro com no máximo 50 caracteres.',
            'cidade.required' => 'Insira uma cidade!',
            'cidade.max' => 'Insira cidade com no máximo 50 caracteres.',
            'cep.required' => 'Insira um CEP!',
            'cep.digits' => 'Insira CEP válido!'
        ];
    }
    public function rules_addData(){
        $estado = "AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO";
        $pais="África do Sul,Albânia,Alemanha,Andorra,Angola,Anguilla,Antigua,Arábia Saudita,Argentina,Armênia,Aruba,Austrália,Áustria,Azerbaijão,Bahamas,Bahrein,Bangladesh,Barbados,Bélgica,Benin,Bermudas,Botsuana,Brasil,Brunei,Bulgária,Burkina Fasso,Botão,Cabo Verde,Camarões,Camboja,Canadá,Cazaquistão,Chade,Chile,China,Cidade do Vaticano,Colômbia,Congo,Coréia do Sul,Costa do Marfim,Costa Rica,Croácia,Dinamarca,Djibuti,Dominica,EUA,Egito,El Salvador,Emirados Árabes,Equador,Eritréia,Escócia,Eslováquia,Eslovênia,Espanha,Estônia,Etiópia,Fiji,Filipinas,Finlândia,França,Gabão,Gâmbia,Gana,Geórgia,Gibraltar,Granada,Grécia,Guadalupe,Guam,Guatemala,Guiana,Guiana Francesa,Guiné-bissau,Haiti,Holanda,Honduras,Hong Kong,Hungria,Iêmen,Ilhas Cayman,Ilhas Cook,Ilhas Curaçao,Ilhas Marshall,Ilhas Turks & Caicos,Ilhas Virgens (brit.),Ilhas Virgens(amer.),Ilhas Wallis e Futuna,Índia,Indonésia,Inglaterra,Irlanda,Islândia,Israel,Itália,Jamaica,Japão,Jordânia,Kuwait,Latvia,Líbano,Liechtenstein,Lituânia,Luxemburgo,Macau,Macedônia,Madagascar,Malásia,Malaui,Mali,Malta,Marrocos,Martinica,Mauritânia,Mauritius,México,Moldova,Mônaco,Montserrat,Nepal,Nicarágua,Niger,Nigéria,Noruega,Nova Caledônia,Nova Zelândia,Omã,Palau,Panamá,Papua-nova Guiné,Paquistão,Peru,Polinésia Francesa,Polônia,Porto Rico,Portugal,Qatar,Quênia,Rep. Dominicana,Rep. Tcheca,Reunion,Romênia,Ruanda,Rússia,Saipan,Samoa Americana,Senegal,Serra Leone,Seychelles,Singapura,Síria,Sri Lanka,St. Kitts & Nevis,St. Lúcia,St. Vincent,Sudão,Suécia,Suiça,Suriname,Tailândia,Tanzânia,Togo,Trinidad & Tobago,Tunísia,Tunísia,Turquia,Ucrânia,Uganda,Uruguai,Venezuela,Vietnã,Zaire,Zâmbia,Zimbábue";
        return [
            'linkedin' => 'max:250',
            'facebook' => 'max:250',
            'twitter' => 'max:250',
            'site' => 'max:250',
            'outraRede' => 'max:250',
            'estado' => 'required|in:'.$estado,
            'fixo' => 'nullable|telefone_com_ddd',
            'celular' => 'required|celular_com_ddd',
            'rua' => 'required|max:250',
            'numero' => 'max:250',
            'complemento' => 'max:250',
            'bairro' => 'required|max:250',
            'cidade' => 'required|max:250',
            'cep'=> 'required|digits:8'
        ];
    }

    public function rules_edit($email, $cnpj){
        return [
            'email' => 'required|max:250|email|unique:users,email,'.$email,
            'password' => 'nullable|min:8|max:30',
            'newPassword' => 'nullable|min:8|max:30',
            'cnpj' => 'required|cnpj|unique:juridicas,cnpj,'.$cnpj
        ];
    }


    
}
