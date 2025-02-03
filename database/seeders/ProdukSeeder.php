<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Inisialisasi Faker

        $produkData = [];

        for ($i = 1; $i <= 500; $i++) {
            $produkData[] = [
                'kode_produk' => 'P' . str_pad($i, 3, '0', STR_PAD_LEFT), // P001, P002, ..., P500
                'nama_barang' => $faker->words(3, true), // Nama barang acak (3 kata)
                'gambar' => $faker->imageUrl(640, 480, 'product', true, 'Faker'), // URL gambar acak
                'id_size' => $faker->numberBetween(1, 5), // ID size antara 1-10 (contoh)
                'id_warna' => $faker->numberBetween(1, 5), // ID warna antara 1-10 (contoh)
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert 500 produk ke tabel
        DB::table('produk')->insert($produkData);
    }
}
