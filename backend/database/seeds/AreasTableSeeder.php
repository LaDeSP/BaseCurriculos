<?php

use Illuminate\Database\Seeder;
use App\Area;

class AreasTableSeeder extends Seeder
{
   
    public function run()
    {
        Area::create(['tipo'=> 'Administração Comercial/Vendas']);
        Area::create(['tipo'=> 'Administração de Empresas']);
        Area::create(['tipo'=> 'Administração Comercial/Vendas']);
        Area::create(['tipo'=> 'Administração Pública']);
        Area::create(['tipo'=> 'Advocacia Jurídica']);
        Area::create(['tipo'=> 'Agronomia']);
        Area::create(['tipo'=> 'Arquitetura de Urbanismo']);
        Area::create(['tipo'=> 'Arquivologia']);
        Area::create(['tipo'=> 'Artes Cênicas']);
        Area::create(['tipo'=> 'Artes Gŕaficas']);
        Area::create(['tipo'=> 'Artes Plásticas']);
        Area::create(['tipo'=> 'Atendimento ao Cliente - Bar e Restaurante']);
        Area::create(['tipo'=> 'Atendimento ao Cliente - Telefonista/Recepcionista']);
        Area::create(['tipo'=> 'Atendimento ao Cliente - Telemarketing/Call Center']);
        Area::create(['tipo'=> 'Auditoria']);
        Area::create(['tipo'=> 'Bancos']);
        Area::create(['tipo'=> 'Biomedicina']);
        Area::create(['tipo'=> 'Ciências Sociais']);
        Area::create(['tipo'=> 'Construção Civil']);
        Area::create(['tipo'=> 'Economia']);
        Area::create(['tipo'=> 'Informática/T.I']);
        Area::create(['tipo'=> 'Telecomunicações']);
        Area::create(['tipo'=> 'Recursos Humanos']);
    }
}
