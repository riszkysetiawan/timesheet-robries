<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarnaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $warna = [
            ['warna' => 'ABU NAKO', 'keterangan' => 'ini warna biru nako', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'BILBERRY', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'BIRU NAKO', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'CARROT', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'CHESTNUT', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'DAMSON', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'DARK FUNGI', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'FF04', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'FF06', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'FLAX', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'GRAPE', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'GRAY FUNGI', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'HITAM NAKO', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'JOKOPI', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'JUNIPER', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'Kaledioskop', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'LIGHT TERRARIUM', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'MARIGOLD', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'MERAH SA', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'ORANGE SA', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'PBM SA', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'PEACH', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'PUTIH NAKO', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'ROSE', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'SAGE', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'SEAWEED', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'WAVE', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'WHITE FUNGI', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'White Seed', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
            ['warna' => 'WHITE SEEDS', 'keterangan' => 'ini keterangan warna', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('warna')->insert($warna);
    }
}
