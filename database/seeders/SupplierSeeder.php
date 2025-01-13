<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $supplier = [
            ['nama_supplier' => 'Pak Kalim', 'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Bu Saski',   'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'WHC',   'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Pak Bahrul',  'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Shoppe',  'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
            ['nama_supplier' => 'Ekamant',  'alamat' => 'Surabaya', 'no_telp' => '0821928192', 'email' => '', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('supplier')->insert($supplier);
    }
}
