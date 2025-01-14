<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Stock;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Ambil semua kode_barang yang ada di tabel barang
        $barangCodes = Barang::pluck('kode_barang')->toArray();

        // Buat 500 stock
        foreach (range(1, 500) as $index) {
            Stock::create([
                'kode_barang' => $faker->randomElement($barangCodes), // Pilih kode_barang secara acak
                'stock' => $faker->numberBetween(1, 1000), // Stock acak antara 1 dan 1000
            ]);
        }
    }
}
