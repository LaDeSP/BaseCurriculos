<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run()
    {
        $this->call(AreasTableSeeder::class); 
        $this->call(UsersTableSeeder::class); 
        $this->call(VagasTableSeeder::class);    
        
    }
}
