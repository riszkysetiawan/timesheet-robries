<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $kategori_barang = [
            ['nama_kategori' => 'Raw Material', 'keterangan' => 'Produk dengan kemasan kering', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Finished Good', 'keterangan' => 'Produk sensitif seperti kosmetik atau elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Consumable', 'keterangan' => 'Produk makanan siap saji dan bahan masakan', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategori_barang')->insert($kategori_barang);
    }
}
