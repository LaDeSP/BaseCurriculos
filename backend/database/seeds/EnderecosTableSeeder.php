<?php

use Illuminate\Database\Seeder;
use App\Endereco;

class EnderecosTableSeeder extends Seeder
{
   
    public function run()
    {
        Endereco::create([
            'cep'=>'15410548',
            'rua'=>'14 de março',
            'numero' => '78',
            'complemento' => 'Perto da base naval',
            'bairro'=>'Centro',
            'cidade'=>'Ladário',
            'estado'=>'MS',
            'pais'=>'Brasil',
        ]);
        
        Endereco::create([
            'cep'=>'79370000',
            'rua'=>'Rua Tamandaré',
            'numero'=> '66',
            'complemento' => 'Abaixo da rua 14 de março',
            'bairro'=>'Centro',
            'cidade'=>'Ladário',
            'estado'=>'MS',
            'pais'=>'Brasil',
        ]);

    }
}
