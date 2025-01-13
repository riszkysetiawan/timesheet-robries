<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CompanyProfile;
use App\Http\Requests\StoreCompanyProfileRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailInbound;
use Yajra\DataTables\DataTables;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $profiles = CompanyProfile::select(['id', 'nama', 'alamat', 'email', 'no_telp', 'foto']);

            return DataTables::of($profiles)
                ->addIndexColumn()
                ->editColumn('foto', function ($profil) {
                    // Buat URL lengkap untuk foto (jika ada)
                    return $profil->foto ? asset('storage/' . $profil->foto) : null;
                })
                ->addColumn('action', function ($profil) {
                    $editUrl = route('profil.company.admin.edit', Crypt::encryptString($profil->id));
                    return '
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>
                    ';
                })
                ->rawColumns(['foto', 'action'])
                ->make(true);
        }

        return view('superadmin.profile-company.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(ProfileCompany $profileCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $profiles = CompanyProfile::findOrFail($decryptedId);
        return view('superadmin.profile-company.update', compact('profiles'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telp' => 'required|string|max:15',
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // Foto opsional, maksimal 10MB
        ], [
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.string' => 'Nomor telepon harus berupa teks.',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter.',
            'nama.required' => 'Nama toko wajib diisi.',
            'nama.string' => 'Nama toko harus berupa teks.',
            'nama.max' => 'Nama toko tidak boleh lebih dari 255 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal adalah 10 MB.',
        ]);

        // Return error jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Ambil data profil yang akan diperbarui
        $profile = CompanyProfile::findOrFail($decryptedId);

        // Update data teks
        $profile->alamat = $request->alamat;
        $profile->email = $request->email;
        $profile->no_telp = $request->no_telp;
        $profile->nama = $request->nama;

        // Cek apakah ada file foto baru yang diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($profile->foto && file_exists(public_path('storage/' . $profile->foto))) {
                unlink(public_path('storage/' . $profile->foto));
            }

            // Simpan foto baru
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/profil', $fileName, 'public');

            // Update kolom foto dengan path foto baru
            $profile->foto = $filePath;
        } else {
            // Jika tidak ada file baru, tetap gunakan foto lama
            $profile->foto = $request->foto_lama;
        }

        // Simpan perubahan ke database
        $profile->save();

        // Kembalikan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Data profil berhasil diperbarui!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan user berdasarkan ID
        $profile = CompanyProfile::find($id);

        // Cek apakah user ada
        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $profile->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
