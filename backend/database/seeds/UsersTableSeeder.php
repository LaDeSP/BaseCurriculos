<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Aruana', 
            'email' => 'aruana@admin.com',
            'password' => bcrypt('12345678'),
            'role' => 'MASTER',
            'status' => 'ATIVO'
        ]);

        User::create([
            'name' =>  'Lana Banana',
            'email' => 'lana@hotmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'FISICA',
            'status' => 'ATIVO'
        ]);

        User::create([
            'name' =>  'Sansa Tech',
            'email' => 'sansa@hotmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'JURIDICA',
            'status' => 'ATIVO'
        ]);
        
    }
}

