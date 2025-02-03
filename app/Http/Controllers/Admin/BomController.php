<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Bom;
use App\Http\Requests\StoreBomRequest;
use App\Http\Requests\UpdateBomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailInbound;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\BarangsExport;
use App\Imports\BarangImport;
use App\Exports\LaporanBarangExport;
use App\Models\Barang;
use App\Models\DetailBom;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('superadmin.bom.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil semua produk
        $products = Produk::all();

        // Mengambil barang dengan kategori 'Raw Material'
        $barangs = Barang::whereHas('kategori', function ($query) {
            $query->where('nama_kategori', '=', 'Raw Material');
        })->get();

        // Mengarahkan ke view create BOM dengan data yang diperlukan
        return view('superadmin.bom.create', compact('products', 'barangs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_product' => 'required|exists:produk,kode_produk',
            'qty' => 'required|numeric|min:1',
            'kode_barang.*' => 'required|exists:barang,kode_barang',
            'persentase.*' => 'required|numeric|min:0|max:100',
            'gramasi.*' => 'required|numeric|min:0',
        ], [
            'kode_product.required' => 'Produk harus dipilih.',
            'kode_product.exists' => 'Produk tidak ditemukan.',
            'qty.required' => 'Gramasi utama harus diisi.',
            'qty.numeric' => 'Gramasi utama harus berupa angka.',
            'kode_barang.*.required' => 'Bahan harus dipilih.',
            'kode_barang.*.exists' => 'Bahan tidak ditemukan.',
            'persentase.*.required' => 'Presentase bahan harus diisi.',
            'persentase.*.numeric' => 'Presentase bahan harus berupa angka.',
            'gramasi.*.required' => 'Gramasi bahan harus diisi.',
            'gramasi.*.numeric' => 'Gramasi bahan harus berupa angka.',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data ke tabel BOM
            $bom = Bom::create([
                'kode_produk' => $request->kode_product,
                'qty' => $request->qty,
            ]);

            // Simpan semua detail BOM
            foreach ($request->kode_barang as $index => $kode_barang) {
                DetailBom::create([
                    'id_bom' => $bom->id,
                    'kode_barang' => $kode_barang,
                    'persentase' => $request->persentase[$index],
                    'gramasi' => $request->gramasi[$index],
                ]);
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data BOM berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Bom $bom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bom $bom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBomRequest $request, Bom $bom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bom $bom)
    {
        //
    }
}
