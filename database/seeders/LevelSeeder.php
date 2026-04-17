<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_level')->insert([
            [
                'level_kode' => 'ADM',
                'level_nama' => 'Admin',
            ],
            [
                'level_kode' => 'KSR',
                'level_nama' => 'Kasir',
            ],
        ]);
    }
}