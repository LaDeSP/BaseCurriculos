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
            'password' => bcrypt('123456'),
            'role' => 'ADMIN'
        ]);

        User::create([
            'name' =>  'Lana',
            'email' => 'lana@hotmail.com',
            'password' => bcrypt('123456'),
            'role' => 'FISICA'
        ]);

        User::create([
            'name' =>  'Sansa',
            'email' => 'sansa@hotmail.com',
            'password' => bcrypt('123456'),
            'role' => 'JURIDICA'
        ]);
        
    }
}

