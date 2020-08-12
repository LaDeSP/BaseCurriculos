<?php

use Illuminate\Database\Seeder;
use App\Curriculo;
use App\HistoricoProfissional;

class CurriculosTableSeeder extends Seeder
{
 
    public function run()
    {
        HistoricoProfissional::create([
            'data_inicial' => '2019-01-08',
            'data_final' => '2020-01-01',
            'descricao_experiencia' => 'Trabalhei como desenvolvedora júnior na Sansa Tech.'
        ]);        
        
        Curriculo::create([
            'objetivos'=>'Ganhar experiência para poder me desenvolver bem como programadora sênior.',
            'pretensao'=>'2.000',
            'escolaridade'=>'Ensino Superior(Completo)',
            'qualificacoes'=>'Experiências com PHP, Python e Javascript. Trabalho bem em equipe.',
            'historicosP_id' => 1,
            'fisicas_id'=>1,
            'areas_id'=>21,
        ]);
    }
}
