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
            ['nama' => 'PPIC',  'keterangan' => 'null',  'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Operator Warehouse',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Operator Produksi',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Warehouse',   'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Manajer Produksi',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'QC',  'keterangan' => 'null', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('role')->insert($role);
    }
}
