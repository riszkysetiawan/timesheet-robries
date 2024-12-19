<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CompanyProfile;
use App\Models\VendorPengiriman;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AreaMappingSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            SizeSeeder::class,
            WarnaSeeder::class,
            ProsesSeeder::class,
            CompanyProfileSeeder::class,
            AlasanWasteSeeder::class,
            SatuanBarangSeeder::class,
            VendorPengirimanSeeder::class,
        ]);
    }
}
