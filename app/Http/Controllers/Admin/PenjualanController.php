<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Penjualan;
use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\KategoriExport;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $penjualan = Penjualan::with('detailpenjualan')->get();

            return DataTables::of($penjualan)
                ->addIndexColumn() // Tambahkan baris ini untuk kolom nomor urut
                ->addColumn('action', function ($penjualan) {
                    $editUrl = route('penjualan.admin.edit', Crypt::encryptString($penjualan->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $penjualan->id . ')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>
                        <button class="btn btn-primary btn-sm btn-detail"
                        data-id="' . $penjualan->id . '"">Detail</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.penjualan.index');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('detailpenjualan')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $penjualan,
            'details' => $penjualan->detailpenjualan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'so_number' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'shipping' => 'required|date',
            'catatan' => 'nullable|string',
            'note.*' => 'nullable|string|max:255',
            'pesanan.*' => 'required|string|max:255',
            'qty.*' => 'required|numeric|min:1',
            'deskripsi.*' => 'nullable|string|max:255',
        ], [
            // Pesan error dalam bahasa Indonesia
            'so_number.required' => 'SO Number harus diisi.',
            'so_number.string' => 'SO Number harus berupa teks.',
            'so_number.max' => 'SO Number tidak boleh lebih dari 255 karakter.',
            'nama_customer.required' => 'Nama Customer harus diisi.',
            'nama_customer.string' => 'Nama Customer harus berupa teks.',
            'nama_customer.max' => 'Nama Customer tidak boleh lebih dari 255 karakter.',
            'shipping.required' => 'Tanggal Shipping harus diisi.',
            'shipping.date' => 'Tanggal Shipping harus berupa tanggal yang valid.',
            'pesanan.*.required' => 'Pesanan harus diisi.',
            'pesanan.*.string' => 'Pesanan harus berupa teks.',
            'pesanan.*.max' => 'Pesanan tidak boleh lebih dari 255 karakter.',
            'qty.*.required' => 'Jumlah (Qty) harus diisi.',
            'qty.*.numeric' => 'Jumlah (Qty) harus berupa angka.',
            'qty.*.min' => 'Jumlah (Qty) harus minimal 1.',
            'deskripsi.*.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.*.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'note.*.string' => 'Catatan harus berupa teks.',
            'note.*.max' => 'Catatan tidak boleh lebih dari 255 karakter.',
        ]);

        try {
            // Simpan data ke tabel penjualan
            $penjualan = new Penjualan();
            $penjualan->so_number = $request->so_number;
            $penjualan->nama_customer = $request->nama_customer;
            $penjualan->shipping = $request->shipping;
            $penjualan->catatan = $request->catatan;
            $penjualan->save();

            // Simpan data ke tabel detail_penjualans
            foreach ($request->pesanan as $key => $value) {
                $detail = new DetailPenjualan();
                $detail->id_penjualan = $penjualan->id;
                $detail->pesanan = $value;
                $detail->qty = $request->qty[$key];
                $detail->deskripsi = $request->deskripsi[$key];
                $detail->note = $request->note[$key] ?? '';
                $detail->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        try {
            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);
            $penjualan = Penjualan::with('detailpenjualan')->findOrFail($id);
            return view('superadmin.penjualan.update', compact('penjualan'));
        } catch (\Exception $e) {
            return redirect()->route('penjualan.admin.index')->with('error', 'Data tidak ditemukan atau terjadi kesalahan.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        // Dekripsi ID
        $id = Crypt::decryptString($encryptedId);

        // Validasi input
        $request->validate([
            'so_number' => 'required|string|max:255',
            'nama_customer' => 'required|string|max:255',
            'shipping' => 'required|date',
            'catatan' => 'nullable|string',
            'note.*' => 'nullable|string|max:255',
            'pesanan.*' => 'required|string|max:255',
            'qty.*' => 'required|numeric|min:1',
            'deskripsi.*' => 'nullable|string|max:255',
        ], [
            'so_number.required' => 'SO Number harus diisi.',
            'so_number.string' => 'SO Number harus berupa teks.',
            'so_number.max' => 'SO Number tidak boleh lebih dari 255 karakter.',
            'nama_customer.required' => 'Nama Customer harus diisi.',
            'nama_customer.string' => 'Nama Customer harus berupa teks.',
            'nama_customer.max' => 'Nama Customer tidak boleh lebih dari 255 karakter.',
            'shipping.required' => 'Tanggal Shipping harus diisi.',
            'shipping.date' => 'Tanggal Shipping harus berupa tanggal yang valid.',
            'pesanan.*.required' => 'Pesanan harus diisi.',
            'pesanan.*.string' => 'Pesanan harus berupa teks.',
            'pesanan.*.max' => 'Pesanan tidak boleh lebih dari 255 karakter.',
            'qty.*.required' => 'Jumlah (Qty) harus diisi.',
            'qty.*.numeric' => 'Jumlah (Qty) harus berupa angka.',
            'qty.*.min' => 'Jumlah (Qty) harus minimal 1.',
            'deskripsi.*.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.*.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'note.*.string' => 'Catatan harus berupa teks.',
            'note.*.max' => 'Catatan tidak boleh lebih dari 255 karakter.',
        ]);

        try {
            // Cari data penjualan berdasarkan ID yang sudah didekripsi
            $penjualan = Penjualan::findOrFail($id);

            // Update data penjualan hanya jika ada perubahan
            if ($request->has('so_number')) {
                $penjualan->so_number = $request->so_number;
            }
            if ($request->has('nama_customer')) {
                $penjualan->nama_customer = $request->nama_customer;
            }
            if ($request->has('shipping')) {
                $penjualan->shipping = $request->shipping;
            }
            if ($request->has('catatan')) {
                $penjualan->catatan = $request->catatan;
            }
            $penjualan->save();

            // Update detail penjualan
            $detailPenjualanLama = $penjualan->detailpenjualan()->get();
            $penjualan->detailpenjualan()->delete();

            // Menyusun detail yang baru
            foreach ($request->pesanan as $key => $value) {
                if (isset($request->detail_id[$key])) {
                    $detail = DetailPenjualan::where('id_penjualan', $penjualan->id)
                        ->where('id', $request->detail_id[$key]) // Pastikan detail yang benar diupdate
                        ->first();

                    if ($detail) {
                        // Update hanya jika ada perubahan pada setiap field
                        $detail->pesanan = $value;
                        $detail->qty = $request->qty[$key];
                        $detail->deskripsi = $request->deskripsi[$key] ?? $detail->deskripsi;
                        $detail->note = $request->note[$key] ?? $detail->note;
                        $detail->save();
                    }
                } else {
                    // Untuk barang baru, simpan detailnya
                    DetailPenjualan::create([
                        'id_penjualan' => $penjualan->id,
                        'pesanan' => $value,
                        'qty' => $request->qty[$key],
                        'deskripsi' => $request->deskripsi[$key] ?? null,
                        'note' => $request->note[$key] ?? null,
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage(),
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        DB::beginTransaction();
        try {
            // Ambil detail penjualan lama
            $detailPenjualan = $penjualan->detailPenjualan;
            // Hapus detail penjualan
            $penjualan->detailPenjualan()->delete();
            // Hapus data penjualan itu sendiri
            $penjualan->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Data penjualan dan detail penjualan berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
