<?php

use Illuminate\Database\Seeder;

use App\Vaga;

class VagasTableSeeder extends Seeder
{
    
    public function run()
    {
       Vaga::create([
            'titulo'=>'norman rockwell',
            'cargo'=>'ADM',
            'salario'=>'87,319',
            'beneficio'=>'nao tem',
            'jornada'=>'100 horas',
            'requisito'=>'kkkk',
            'quantidade'=>'2',
            'status'=>'ATIVA',
            'juridicas_id'=>1,
            'areas_id'=>5,
       ]);
    }
}
