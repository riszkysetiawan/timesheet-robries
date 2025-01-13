<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OvenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $oven = [
            ['nama' => 'Oven 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 2',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 3',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 4',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 5',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 6',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 7',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 8',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven 9',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('oven')->insert($oven);
    }
}
