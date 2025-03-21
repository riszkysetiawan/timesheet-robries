<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return view('superadmin.profile.index', compact('user'));
    }
    public function indexOperatorProduksi()
    {
        $user = Auth::user();
        return view('operator-produksi.profile.index', compact('user'));
    }
    public function indexStaffProduksi()
    {
        $user = Auth::user();
        return view('staff-produksi.profile.index', compact('user'));
    }
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Autentikasi pengguna
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role->nama) {
                case 'Superadmin':
                    return response()->json(['status' => 'success', 'redirect' => route('dashboard.superadmin')]);
                case 'Staff Produksi':
                    return response()->json(['status' => 'success', 'redirect' => route('dashboard.staff-produksi')]);
                case 'Operator Produksi':
                    return response()->json(['status' => 'success', 'redirect' => route('dashboard.operator-produksi')]);
                case 'Quality Control':
                    return response()->json(['status' => 'success', 'redirect' => route('dashboard.operator-produksi')]);
                default:
                    Auth::logout(); // Log out jika role tidak cocok
                    return response()->json(['errors' => ['role' => 'Role tidak valid.']], 403);
            }
        }

        // Jika autentikasi gagal
        return response()->json(['errors' => ['email' => 'Email atau password salah.']], 422);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index.login');
    }
    public function logoutStaffProduksi()
    {
        Auth::logout();
        return redirect()->route('index.login');
    }
    public function logoutOperatorProduksi()
    {
        Auth::logout();
        return redirect()->route('index.login');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'old_password' => 'nullable|min:6',
            'new_password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai.'
                ], 422);
            }
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }

            $imageName = time() . '.' . $request->foto->extension();
            $filePath = $request->file('foto')->storeAs('public/photos', $imageName);
            $user->foto = 'photos/' . $imageName;
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();

        // Kembalikan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
    public function updateStaffProduksi(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'old_password' => 'nullable|min:6',
            'new_password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai.'
                ], 422);
            }
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }

            $imageName = time() . '.' . $request->foto->extension();
            $filePath = $request->file('foto')->storeAs('public/photos', $imageName);
            $user->foto = 'photos/' . $imageName;
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();

        // Kembalikan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }
    public function updateOperatorProduksi(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'old_password' => 'nullable|min:6',
            'new_password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000'
        ]);
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai.'
                ], 422);
            }
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }

            $imageName = time() . '.' . $request->foto->extension();
            $filePath = $request->file('foto')->storeAs('public/photos', $imageName);
            $user->foto = 'photos/' . $imageName;
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();

        // Kembalikan pesan sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
