<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Juridica;
use App\Fisica;
use App\Curriculo;
use App\Contato;
use App\Endereco;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'role' => 'ADMIN'
        ]);

        User::create([
            'name' =>  'Lana',
            'email' => 'lana@hotmail.com',
            'password' => bcrypt('123456'),
            'role' => 'FISICA'
        ]);

        Contato::create([
            'fixo'=>'3333333',
            'celular'=>'111111',
            'facebook'=>'oasjoajdpa',
            'twitter'=>'@djoadhoa',
        ]);
        
        Endereco::create([
            'cep'=>'15410548',
            'rua'=>'ruaaahhihdao',
            'bairro'=>'centro',
            'cidade'=>'ladario city',
            'estado'=>'ms',
            'pais'=>'brasil',
        ]);

        Fisica::create([
            'user_id'=>2,
            'cpf'=>'98269595',
            'genero'=>'Feminino',
            'estado_civil'=>'solteiro',
            'contatos_id'=>1,
            'enderecos_id'=>1
        ]);

        Curriculo::create([
            'objetivos'=>'naosei',
            'pretensao'=>'80,00',
            'escolaridade'=>'ensino medio',
            'qualificacoes'=>'Dont cry',
            'historicoProfissional'=>'Curse',
            'fisicas_id'=>1,
            'areas_id'=>3,
        ]);

        User::create([
            'name' =>  'Sansa',
            'email' => 'sansa@hotmail.com',
            'password' => bcrypt('123456'),
            'role' => 'JURIDICA'
        ]);
        
        Contato::create([
            'fixo'=>'00000',
            'celular'=>'777777',
            'site'=>'prettycamera.com',
            'twitter'=>'@hohoi',
        ]);
        
        Endereco::create([
            'cep'=>'666666',
            'rua'=>'hellohello',
            'bairro'=>'centro',
            'cidade'=>'corumba city',
            'estado'=>'ms',
            'pais'=>'brasil',
        ]);

        Juridica::create([
            'user_id'=>3,
            'cnpj'=>'1111111',
            'ramo'=>'SummerTime Sadness',
            'contatos_id'=>2,
            'enderecos_id'=>2
        ]);
        
    }
}

