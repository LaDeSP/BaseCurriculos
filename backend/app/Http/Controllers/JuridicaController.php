<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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
        /*$validaCNPJ = JuridicaController::isCnpjValid($request->cnpj);
        if($validaCNPJ!="true"){
            $error[] = $validaCNPJ;
        } */

        if(!$request->name){
            $error[] = 'Insira o nome!';
        }
        else{
            if(strlen($request->name)>50){
                $error[] = 'Insira nome com no máximo 50 aracteres!';
            }
        }
          
        if(!$request->ramo){
            $error[] = 'Insira o ramo!';
        }
        else{
            if(strlen($request->ramo)>50){
                $error[] = 'Insira ramo com no máximo 50 aracteres!';
            }
        }

        if(!$request->email){
            $error[] = 'Insira o email!';
        }
        else{
            $buscaEmail = User::where('email', $request->email)->first();
            if($buscaEmail){
                $error[] = 'Email inserido já foi cadastrado.';
            }
            else {
                if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
                    $error[] = 'Insira email válido!';
                }
            }
        }
        
        if(!$request->password){
            $error[] = 'Insira uma senha!';
        }
        else{
            if(strlen($request->password)<8){
                $error[] = 'Insira uma senha com no mínimo 8 caracteres!';
            }
            else if(strlen($request->password)>30){
                $error[] = 'Insira uma senha com no máximo 30 caracteres!';
            }
        }


        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }

        $this->validate($request, [
            'name' => 'required',
            'cnpj' => 'required',
            'email' => 'required|email|unique:users',
            ]); 

            $this->register($request);
            
            $pjuridica = new Juridica();
            $cnpj = $pjuridica->cnpj = $request->input('cnpj');
            $ramo = $pjuridica->ramo = $request->input('ramo');
            $email = $request->input('email');
            $id = User::where('email', $email)->first()->id;
            $pjuridica->user_id = $id;

            $pjuridica->save();

            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
           // $user = User::find($id);
            //$token = auth()->login($user);
            return Response::json([
                'token'=> $token,
                'name' => $request->input('name'),
                'role' => $request->input('role'),
                'user_id'=> auth()->user()->id,
                'message' => 'Pessoa Jurídica cadastrada com sucesso!'
             ], 201); 
    }

    public function addData(Request $request){
        if(!$request->razao){
            $error[] = 'Insira sua razão social!';
        }
        else {
            if(strlen($request->razao)>50){
                $error[] = 'Insira sua razão social com no máximo 50 caracteres!';
            }
        }
        
        if(!$request->missao){
            $error[] = 'Insira sua missão!';
        }
        else {
            if(strlen($request->missao)>500){
                $error[] = 'Insira sua missão com no máximo 500 caracteres!';
            }
        }
        
        if($request->linkedin){
            if(strlen($request->linkedin)>50){
                $error[] = 'Insira um linkedin com no máximo 50 caracteres!';
            }
        }

        if($request->facebook){
            if(strlen($request->facebook)>50){
                $error[] = 'Insira um facebook com no máximo 50 caracteres!';
            }
        }

        if($request->twitter){
            if(strlen($request->twitter)>50){
                $error[] = 'Insira um twitter com no máximo 50 caracteres!';
            }
        }

        if($request->site){
            if(strlen($request->site)>50){
                $error[] = 'Insira o site com no máximo 50 caracteres!';
            }
        }

        if($request->outraRede){
            if(strlen($request->outraRede)>50){
                $error[] = 'Insira sua outra rede com no máximo 50 caracteres!';
            }
        }

        /*if($request->emailAlt){
            if(!filter_var($request->emailAlt, FILTER_VALIDATE_EMAIL)){
                $error[] = 'Insira email válido no campo email alternativo!';
            }
            else if(strlen($request->emailAlt)>50){
                $error[] = 'Insira seu email alternativo com no máximo 50 caracteres!';
            }
        }*/

        if(!$request->pais){
            $error[] = 'Insira o país!';
        }

        if(!$request->estado){
            $error[] = 'Insira o estado!';
        }

        if(!$request->fixo){
            $error[] = 'Insira número fixo!';
        }
        else{
            /*if(CurriculoController::celular($request->fixo)==false){
                $error[] = 'Digite número fixo válido!';
            }*/
        }
        
        if(!$request->celular){
            $error[] = 'Insira número de celular!';
        }
        else{ 
            /*if(CurriculoController::celular($request->celular)==false){
                $error[] = 'Digite celular válido!';
            } */
        }
        
        if(!$request->rua){
            $error[] = 'Insira a rua!';
        }
        else {
            if(strlen($request->rua)>50){
                $error[] = 'Insira sua rua com no máximo 50 caracteres!';
            }
        }

        if(!$request->bairro){
            $error[] = 'Insira o bairro!';
        }
        else {
            if(strlen($request->bairro)>50){
                $error[] = 'Insira seu bairro com no máximo 50 caracteres!';
            }
        }

        if(!$request->cidade){
            $error[] = 'Insira a cidade!';
        }
        else {
            if(strlen($request->cidade)>50){
                $error[] = 'Insira sua cidade com no máximo 50 caracteres!';
            }
        }
        
        if(!$request->cep){
            $error[] = 'Insira o CEP!';
        }
        else{
            /*if(CurriculoController::validarCep($request->cep)==false){
                $error[] = 'Digite CEP válido!';
            }*/
        }
        
        
        if(isset($error)){
            return Response::json([
            'error' => $error
        ], 201);
        }
       
        $con_id = Contato::insertGetId([
            'celular' => $request->input('celular'),
            'fixo' => $request->input('fixo'),
            'linkedin' => $request->input('linkedin'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'site' => $request->input('site'),
            'outraRede' => $request->input('outraRede')
        ]);

        $end_id = Endereco::insertGetId([
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'complemento' => $request->input('complemento'),
            'numero' => $request->input('numero'),
            'pais' => $request->input('pais'),
            'cep' => $request->input('cep')
        ]);
        
        Juridica::where('user_id', $request->input('user_id'))
        ->update(array(
            'razao' => $request->input('razao'),
            'missao' => $request->input('missao'),
            'contatos_id' => $con_id, 
            'enderecos_id' => $end_id

        ));

        return Response::json([
            'message' => 'Dados cadastrados com sucesso!'
         ], 201);

    }

    public function show($id)
    {
        $juridica = Juridica::with(['contato', 'endereco', 'user'])->where('user_id', $id)->get();
        return Response::json([
            'juridica' => $juridica
         ], 201);
    }


    public function update(Request $request, $id)
    {
        $end_id = Juridica::where('user_id', $id)->value('enderecos_id');
        $con_id = Juridica::where('user_id', $id)->value('contatos_id');

        //User::where('id', $id)->update(['name'=>$request->nome]);

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

        Juridica::where('user_id', $id)->update(array(
                'razao' => $request->razao,
                'missao' => $request->missao,
                'contatos_id' => $con_id, 
                'enderecos_id' => $end_id
            ));

        return Response::json([
            'SEI LA MAN'=>$request->user_id
           ], 201);
      
      
    }

    public function destroy($id)
    {
    
        $end_id = Juridica::where('user_id', $id)->first()->enderecos_id;
        $cont_id = Juridica::where('user_id', $id)->first()->contatos_id;
        
        $user = User::find($id);
        $user->delete();

        $end = Endereco::find($end_id);
        $end->delete();

        $cont = Contato::find($cont_id);
        $cont->delete();
        
        return Response::json([
            'msg' => 'deletado ok'
         ], 201);
    }

    function isCnpjValid($cnpj){
        if(empty($cnpj)) {
            return "Insira um CNPJ!";
        }
        //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
        $j=0;
        for($i=0; $i<(strlen($cnpj)); $i++){
            if(is_numeric($cnpj[$i])){
                $num[$j]=$cnpj[$i];
                $j++;
            }
        }
        $buscaCNPJ = Juridica::where('cnpj', $cnpj)->first();
        if($buscaCNPJ){
            return "CNPJ inserido já foi cadastrado.";
        }
        //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
        if(count($num)!=14){
                $isCnpjValid=false;
        }
        //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
        if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0){
            $isCnpjValid=false;
        }
        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        else{
            $j=5;
            for($i=0; $i<4; $i++){
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j=9;
            for($i=4; $i<12; $i++){
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);	
            $resto = $soma%11;			
            if($resto<2){
                $dg=0;
            }
            else{
                $dg=11-$resto;
            }
            if($dg!=$num[12]){
                $isCnpjValid=false;
            } 
        }
        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if(!isset($isCnpjValid)){
            $j=6;
            for($i=0; $i<5; $i++){
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j=9;
            for($i=5; $i<13; $i++){
                $multiplica[$i]=$num[$i]*$j;
                $j--;
            }
            $soma = array_sum($multiplica);	
            $resto = $soma%11;			
            if($resto<2){
                $dg=0;
            }
            else{
                $dg=11-$resto;
            }
            if($dg!=$num[13]){
                $isCnpjValid=false;
            }
            else{
                $isCnpjValid=true;
            }
        }
        //Trecho usado para depurar erros.
        /*
        if($isCnpjValid==true)
            {
                echo "<p><font color="GREEN">Cnpj é Válido</font></p>";
            }
        if($isCnpjValid==false)
            {
                echo "<p><font color="RED">Cnpj Inválido</font></p>";
            }
        */
        //Etapa 6: Retorna o Resultado em um valor booleano.
        //return $isCnpjValid;	
        if ($isCnpjValid==true){
            return "true";
        }
        else {
            return "Insira CNPJ válido";
        }
	}
}
