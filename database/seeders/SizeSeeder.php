<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $size = [
            ['size' => '950x400x10', 'created_at' => now(), 'updated_at' => now()],
            ['size' => '950x400x15',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '950x400x20',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1000x500x10',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1000x500x15',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1000x500x20',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1200x600x10',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1200x600x15',  'created_at' => now(), 'updated_at' => now()],
            ['size' => '1200x600x20',  'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('size')->insert($size);
    }
}
