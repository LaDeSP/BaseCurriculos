<?php

use Illuminate\Database\Seeder;
use App\Contato;

class ContatosTableSeeder extends Seeder
{
    
    public function run()
    {
        Contato::create([
            'fixo'=>'(67)33313-2630',
            'celular'=>'(67)996172498',
            'facebook'=>'Lana Banana Mazó',
            'twitter'=>'@LanaBM',
        ]);
        
        Contato::create([
            'fixo'=>'(67)3226-1465',
            'celular'=>'(67)999724744',
            'site'=>'sansatech.com',
            'twitter'=>'@SansaTech',
        ]);

    }
}
