<?php

use Illuminate\Database\Seeder;
use App\Fisica;

class FisicasTableSeeder extends Seeder
{
    
    public function run()
    {
        Fisica::create([
            'user_id'=>2,
            'cpf'=>'84383846092',
            'genero'=>'Feminino',
            'estado_civil'=>'Solteiro',
            'data_nascimento'=>'1996-06-06',
            'contatos_id'=>1,
            'enderecos_id'=>1
        ]);

    }
}
