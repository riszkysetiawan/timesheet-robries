<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Membuat 500 data penjualan
        foreach (range(1, 500) as $index) {
            // Membuat nomor SO acak
            $so_number = 'SO-' . strtoupper($faker->unique()->lexify('??????'));

            // Membuat data penjualan baru
            $penjualan = Penjualan::create([
                'so_number' => $so_number,
                'nama_customer' => $faker->company,
                'shipping' => $faker->address,
                'catatan' => $faker->optional()->sentence,
            ]);

            // Membuat detail penjualan untuk setiap penjualan
            foreach (range(1, rand(1, 5)) as $detailIndex) {
                $penjualan->detailPenjualan()->create([
                    'id_penjualan' => $penjualan->id,
                    'pesanan' => 'Barang ' . $faker->word,
                    'qty' => $faker->numberBetween(1, 100),
                    'deskripsi' => $faker->optional()->sentence,
                    'note' => $faker->optional()->sentence,
                ]);
            }
        }
    }
}
