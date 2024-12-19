<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlasanWasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ['alasan' => 'Menguning',  'created_at' => now(), 'updated_at' => now()],
            ['alasan' => 'Campur',    'created_at' => now(), 'updated_at' => now()],
            ['alasan' => 'Lapuk',   'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('alasan_waste')->insert($role);
    }
}
