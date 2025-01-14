<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\SatuanBarang;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Ambil semua id_satuan dan id_kategori yang ada di tabel
        $satuanIds = SatuanBarang::pluck('id')->toArray();
        $kategoriIds = Kategori::pluck('id')->toArray();

        // Buat 500 barang
        foreach (range(1, 500) as $index) {
            Barang::create([
                'kode_barang' => $faker->unique()->regexify('[A-Z]{3}[0-9]{4}'), // Kode barang, contoh: ABC1234
                'nama_barang' => $faker->word() . ' ' . $faker->word(), // Nama barang, contoh: Laptop Dell
                'id_satuan' => $faker->randomElement($satuanIds), // ID satuan yang diambil secara acak
                'type' => $faker->word(), // Type barang, contoh: Elektronik
                'id_kategori' => $faker->randomElement($kategoriIds), // ID kategori yang diambil secara acak
            ]);
        }
    }
}
