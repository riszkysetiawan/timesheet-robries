<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Imports\UserImport as ImportsUserImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use DataTables;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use UserImport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with(['role:id,nama']) // Memuat relasi dengan kolom spesifik
                ->select(['id', 'nama', 'no_hp', 'email', 'foto', 'id_role']) // role_id dibutuhkan untuk relasi
                ->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    return $user->role ? $user->role->nama : '-';
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('user.edit', Crypt::encryptString($user->id));
                    return '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $user->id . ')"
                         class="btn btn-outline-danger btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Hapus
                        </a>
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>
                    ';
                })
                ->addColumn('profile', function ($user) {
                    $imgSrc = $user->foto ? asset('storage/' . $user->foto) : asset('logo.jpg');
                    return '<img alt="avatar" class="img-fluid rounded-circle" src="' . $imgSrc . '" width="50">';
                })
                ->rawColumns(['action', 'profile'])
                ->make(true);
        }

        return view('superadmin.user.index');
    }
    public function uploadFile()
    {
        return view('superadmin.user.upload');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:20480'
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes' => 'Format file harus berupa .xlsx atau .xls.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 20MB.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        Excel::import(new ImportsUserImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diupload!'
        ], 200);
    }
    public function create()
    {
        $roles = Role::all();
        return view('superadmin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'id_role' => 'required|exists:role,id' // Validasi id_role harus ada di tabel roles
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'foto.image' => 'Foto harus berupa gambar (jpeg, png, jpg).',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'id_role.required' => 'Role wajib dipilih.',
            'id_role.exists' => 'Role yang dipilih tidak valid.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan data user
        $user = new User();
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->id_role = $request->id_role; // Simpan id_role dari tabel roles
        $user->password = Hash::make($request->password);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $filePath = $request->file('foto')->storeAs('public/photos', $imageName);
            $user->foto = 'photos/' . $imageName;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil ditambahkan!'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $user = User::findOrFail($decryptedId);
        $roles = Role::all(); // Ambil semua data role dari tabel roles
        return view('superadmin.user.update', compact('user', 'roles'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Dekripsi ID
        $decryptedId = Crypt::decryptString($id);

        // Validasi data yang dikirim dari form
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric',
            'email' => 'required|email|unique:users,email,' . $decryptedId,
            'id_role' => 'required|exists:role,id', // Validasi id_role harus ada di tabel roles
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'id_role.required' => 'Role wajib dipilih.',
            'id_role.exists' => 'Role yang dipilih tidak valid.'
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user berdasarkan ID yang didekripsi
        $user = User::findOrFail($decryptedId);

        // Update data user
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->id_role = $request->id_role;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil diupdate!'
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan!'
            ], 404);
        }
        if ($user->foto) {
            $filePath = storage_path('app/public/' . $user->foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus!'
        ]);
    }
}
