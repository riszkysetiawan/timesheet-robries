<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ['nama' => 'Superadmin', 'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Staff Produksi',  'keterangan' => 'null',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Operator Warehouse',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Operator Produksi',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Staff Warehouse',   'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Purchasing',   'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Quality Control',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Sales',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('role')->insert($role);
    }
}
