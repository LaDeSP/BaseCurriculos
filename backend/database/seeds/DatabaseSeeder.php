<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(AreasTableSeeder::class); 
        $this->call(UsersTableSeeder::class);
        $this->call(EnderecosTableSeeder::class);
        $this->call(ContatosTableSeeder::class);
        $this->call(FisicasTableSeeder::class);
        $this->call(JuridicasTableSeeder::class);
        $this->call(CurriculosTableSeeder::class);  
        $this->call(VagasTableSeeder::class);    
        
    }
}
