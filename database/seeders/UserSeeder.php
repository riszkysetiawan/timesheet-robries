<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Tambahkan ini
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = DB::table('role')->pluck('id', 'nama')->toArray();
        $users = [
            [
                'nama' => 'Super Admin',
                'id_role' => $roles['Superadmin'],
                'foto' => 'https://via.placeholder.com/150',
                'no_hp' => '081234567890',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Staff Produksi',
                'id_role' => $roles['Staff Produksi'],
                'foto' => 'https://via.placeholder.com/150',
                'no_hp' => '081234567891',
                'email' => 'staffproduksi@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Staff Warehouse',
                'id_role' => $roles['Staff Warehouse'],
                'foto' => 'https://via.placeholder.com/150',
                'no_hp' => '081234567892',
                'email' => 'staffwarehouse@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Purchasing',
                'id_role' => $roles['Purchasing'],
                'foto' => 'https://via.placeholder.com/150',
                'no_hp' => '081234567893',
                'email' => 'purchasing@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
