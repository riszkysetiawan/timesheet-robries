<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = [
            ['nama' => 'JNT',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'PAXEL',    'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'SENTRAL KARGO',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KALOG',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'GOJEK ',    'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'RAYSPEED ASIA SURABAYA',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'KIB CEPAT',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'DELIVEREE',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'LALA MOVE',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'BALI PURNAMA  ',   'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'ATT CARGO',   'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('vendor_pengiriman')->insert($vendor);
    }
}
