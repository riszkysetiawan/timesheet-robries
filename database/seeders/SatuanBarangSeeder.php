<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ['satuan' => 'PCS',  'created_at' => now(), 'updated_at' => now()],
            ['satuan' => 'Karung',    'created_at' => now(), 'updated_at' => now()],
            ['satuan' => 'Pack',   'created_at' => now(), 'updated_at' => now()],
            ['satuan' => 'Kardus',   'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('satuan_barang')->insert($role);
    }
}
