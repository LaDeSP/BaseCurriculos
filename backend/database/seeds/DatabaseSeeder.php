<?php

use Illuminate\Database\Seeder;
use App\Instituicao;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(AreaTableSeeder::class);   
        
    }
}
