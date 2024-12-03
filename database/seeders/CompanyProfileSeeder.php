<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_profiles')->insert([
            [
                'alamat' => 'Jl. Sudirman No. 23, Jakarta',
                'no_telp' => '021-12345678',
                'email' => 'info@perusahaan.com',
                'nama' => 'Toko Jali',
                'foto' => 'null',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
