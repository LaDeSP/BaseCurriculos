<?php

use Illuminate\Database\Seeder;
use App\Curriculo;

class CurriculosTableSeeder extends Seeder
{
 
    public function run()
    {
        Curriculo::create([
            'objetivos'=>'Ganhar experiência para poder me desenvolver bem como programadora júnior.',
            'pretensao'=>'2.000',
            'escolaridade'=>'Ensino Superior(Completo)',
            'qualificacoes'=>'Experiências com PHP, Python e Javascript. Trabalho bem em equipe.',
            'historicoProfissional'=>'Já desenvolvi softwares para o laboratório LADESP da UFMS-CPAN',
            'fisicas_id'=>1,
            'areas_id'=>21,
        ]);
    }
}
