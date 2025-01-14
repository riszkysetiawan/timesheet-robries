<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Ambil data supplier dan barang
        $suppliers = Supplier::pluck('id')->toArray();
        $barang = Barang::pluck('kode_barang')->toArray();

        // Buat 500 purchase orders
        foreach (range(1, 500) as $index) {
            $kode_po = 'PO-' . strtoupper($faker->unique()->lexify('????????'));
            $kode_pi = 'PI-' . strtoupper($faker->unique()->lexify('????????'));

            $purchaseOrder = PurchaseOrder::create([
                'kode_po' => $kode_po,
                'kode_pi' => $kode_pi,
                'id_supplier' => $faker->randomElement($suppliers),
                'tgl_buat' => $faker->date(),
                'eta' => $faker->optional()->date(),
                'total' => $faker->randomFloat(2, 10000, 100000), // Total dalam format angka
                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'catatan' => $faker->sentence,
            ]);

            // Membuat detail purchase order terkait dengan purchase order
            foreach (range(1, rand(1, 5)) as $detailIndex) {
                $barangKode = $faker->randomElement($barang);

                // Mendapatkan harga barang terkait
                $harga = $faker->randomFloat(2, 1000, 10000); // Harga acak per barang
                $qty = $faker->randomNumber(2);

                $purchaseOrder->details()->create([
                    'kode_po' => $purchaseOrder->kode_po,
                    'kode_barang' => $barangKode,
                    'qty' => $qty,
                    'satuan' => 'pcs', // Atur satuan sesuai kebutuhan
                    'sub_total' => $qty * $harga,
                    'harga' => $harga,
                    'keterangan' => $faker->optional()->sentence,
                ]);
            }
        }
    }
}
