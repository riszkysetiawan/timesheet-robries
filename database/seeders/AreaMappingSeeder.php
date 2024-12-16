<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = [
            ['area' => 'A1',  'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A2',    'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A3',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A4',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A5 ',    'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A6',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A7',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A8',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A9',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A10',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A11',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A12',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A13',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A14',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A15',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A16',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A17',   'created_at' => now(), 'updated_at' => now()],
            ['area' => 'A18',   'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('area_mapping')->insert($vendor);
    }
}
