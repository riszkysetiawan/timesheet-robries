<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use App\Models\DetailPurchaseOrder;
use Illuminate\Database\Seeder;
use App\Models\Barang;
use Faker\Factory as Faker;

class DetailPurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker
        $faker = Faker::create();

        // Menambahkan detail purchase order untuk setiap purchase order
        $purchaseOrders = PurchaseOrder::all();

        foreach ($purchaseOrders as $purchaseOrder) {
            // Ambil barang dari database
            $barang = Barang::pluck('kode_barang')->toArray();

            foreach (range(1, rand(1, 5)) as $index) {
                $barangKode = $faker->randomElement($barang);  // Menggunakan Faker di sini
                $qty = rand(1, 10);  // Jumlah barang yang dibeli
                $harga = rand(1000, 5000);  // Harga barang
                $subTotal = $qty * $harga;

                // Menambahkan data ke tabel detail_purchase_order
                DetailPurchaseOrder::create([
                    'kode_po' => $purchaseOrder->kode_po,
                    'kode_barang' => $barangKode,
                    'qty' => $qty,
                    'satuan' => 'pcs',  // Satuan barang
                    'sub_total' => $subTotal,
                    'harga' => $harga,
                    'keterangan' => 'Sample keterangan',  // Keterangan
                ]);
            }
        }
    }
}
