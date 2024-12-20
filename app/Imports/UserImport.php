<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{
    /**
     * Handle the imported data.
     *
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Log::info('Processing row: ' . json_encode($row));

            // Validasi kolom wajib
            if (!isset($row['nama_user']) || !isset($row['email']) || !isset($row['password']) || !isset($row['role'])) {
                Log::error('Missing required fields: ' . json_encode($row));
                continue;
            }

            // Cari role ID berdasarkan nama role
            $role = Role::where('nama', $row['role'])->first();
            if (!$role) {
                Log::error('Role not found: ' . $row['role']);
                continue;
            }

            // Cari user berdasarkan email
            $user = User::where('email', $row['email'])->first();

            try {
                if ($user) {
                    // Jika user ditemukan, update data
                    $user->update([
                        'nama' => $row['nama_user'], // Update nama dari kolom 'nama_user'
                        'password' => Hash::make($row['password']), // Update password
                        'id_role' => $role->id, // Update role
                    ]);
                    Log::info('User updated: ' . $user->email);
                } else {
                    // Jika user tidak ditemukan, buat user baru
                    User::create([
                        'nama' => $row['nama_user'], // Nama dari kolom 'nama_user'
                        'email' => $row['email'], // Email dari kolom 'email'
                        'password' => Hash::make($row['password']), // Enkripsi password
                        'id_role' => $role->id, // ID role dari nama role
                    ]);
                    Log::info('New user created: ' . $row['email']);
                }
            } catch (\Exception $e) {
                Log::error('Failed to process user: ' . $e->getMessage());
                continue;
            }
        }
    }
}
