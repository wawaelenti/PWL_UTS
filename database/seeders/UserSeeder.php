<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_user')->insert([
            [
                'level_id' => 1,
                'username' => 'admin',
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345'),
            ],
            [
                'level_id' => 2,
                'username' => 'kasir',
                'nama' => 'Kasir',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('123456'),
            ],
        ]);
    }
}