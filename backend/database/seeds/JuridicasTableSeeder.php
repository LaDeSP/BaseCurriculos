<?php

use Illuminate\Database\Seeder;
use App\Juridica;

class JuridicasTableSeeder extends Seeder
{
    
    public function run()
    {
        Juridica::create([
            'user_id'=>3,
            'cnpj'=>'95987235000125',
            'ramo'=>'Soluções Tecnológicas',
            'contatos_id'=>2,
            'enderecos_id'=>2
        ]);
    }
}
