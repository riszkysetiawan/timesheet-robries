<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $proses = [
            ['nama' => 'Oven Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Oven Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Press Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Press Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'WBS Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'WBS Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Weld Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Weld Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'VBS Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'VBS Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'HBS Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'HBS Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Poles Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Poles Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Assembly Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Assembly Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Finishing Start',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Finising Finish',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Finish / Rework',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('proses')->insert($proses);
    }
}
