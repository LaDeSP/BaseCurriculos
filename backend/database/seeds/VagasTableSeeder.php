<?php

use Illuminate\Database\Seeder;

use App\Vaga;

class VagasTableSeeder extends Seeder
{
    
    public function run()
    {
       Vaga::create([
            'titulo'=>'Desenvolvedor PHP e Javascript',
            'cargo'=>'Desenvolvedor Full-Stack',
            'descricao'=>'Procuramos profissionais que tenham experiência com desenvolvimento fullstack
             e que já tenha trabalhado com frameworks como Laravel, ReactJS e VueJS.',
            'salario'=>'1.800',
            'beneficio'=>'Vale combustível e vale transporte',
            'jornada'=>'8 horas por dia',
            'requisito'=>'Ser criativo; Ter disciplina para cumprimento de prazos; Saber trabalhar bem em equipe.',
            'quantidade'=>'2',
            'status'=>'ATIVA',
            'juridicas_id'=>1,
            'areas_id'=>21,
       ]);

       Vaga::create([
        'titulo'=>'Gerente de projetos TI',
        'cargo'=>'Gerente de projetos',
        'descricao'=>'Procuramos profissionais que tenham experiência com gerência de projetos',
        'salario'=>'A combinar',
        'beneficio'=>'Vale alimentação e vale transporte',
        'jornada'=>'8 horas por dia',
        'requisito'=>'Ser responsável; Ter disciplina para cumprimento de prazos; Saber trabalhar bem em equipe.',
        'quantidade'=>'1',
        'status'=>'ATIVA',
        'juridicas_id'=>1,
        'areas_id'=>21,
        ]);
    }
}
