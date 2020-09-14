<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'role' => 'ADMIN'
        ]);

        User::create([
            'name' =>  'Lana Banana',
            'email' => 'lana@hotmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'FISICA'
        ]);

        User::create([
            'name' =>  'Sansa Tech',
            'email' => 'sansa@hotmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'JURIDICA'
        ]);
        
    }
}

