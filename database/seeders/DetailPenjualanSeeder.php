<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;

class DetailPenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil semua penjualan
        $penjualans = Penjualan::all();

        // Menambahkan detail untuk setiap penjualan
        foreach ($penjualans as $penjualan) {
            // Membuat detail penjualan acak
            foreach (range(1, rand(1, 5)) as $index) {
                $penjualan->detailPenjualan()->create([
                    'id_penjualan' => $penjualan->id,
                    'pesanan' => 'Barang ' . $index,
                    'qty' => rand(1, 100),
                    'deskripsi' => 'Deskripsi barang ' . $index,
                    'note' => 'Catatan tambahan ' . $index,
                ]);
            }
        }
    }
}
