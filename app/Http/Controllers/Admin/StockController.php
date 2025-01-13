<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\StocksExport;
use App\Imports\StockImport;
use App\Models\Barang;
use App\Models\Produk;
use App\Models\StockMovement;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function uploadExcel(Request $request)
    {
        // Validasi file Excel
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:20480' // 20MB = 20480KB
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes' => 'Format file harus berupa .xlsx atau .xls.',
            'file.max' => 'Ukuran file tidak boleh lebih dari 20MB.'
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses import file Excel
        Excel::import(new StockImport, $request->file('file'));

        return response()->json([
            'status' => 'success',
            'message' => 'Data Stock berhasil diupload!'
        ], 200);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stocks = Stock::with('barang')->select(['id', 'kode_barang', 'stock']);

            return DataTables::of($stocks)
                ->addIndexColumn()
                ->addColumn('action', function ($stock) {
                    $editUrl = route('stock-produk.admin.edit', Crypt::encryptString($stock->id));
                    return '
                    <a href="javascript:void(0)" onclick="confirmDelete(' . $stock->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
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
                ';
                })
                ->addColumn('nama_barang', function ($stock) {
                    return $stock->barang->nama_barang ?? 'Belum Ada';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.stock.index');
    }
    public function getBarangByBarcode($barcode)
    {
        // Cari barang berdasarkan barcode
        $barang = Produk::where('kode_barcode', $barcode)->first();

        if ($barang) {
            return response()->json([
                'kode_produk' => $barang->kode_produk,
                'nama_barang' => $barang->nama_barang
            ]);
        }

        return response()->json(null); // Kembalikan null jika tidak ditemukan
    }

    public function downloadExcel()
    {
        return Excel::download(new StocksExport, 'stocks.xlsx');
    }

    public function downloadPdf()
    {
        $stocks = Stock::with('barang')->get();
        $pdf = PDF::loadView('superadmin.stock.pdf', ['stocks' => $stocks]);

        return $pdf->download('stocks.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        return view('superadmin.stock.create', compact('barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function uploadFile()
    {
        return view('superadmin.stock.upload');
    }
    public function store(Request $request)
    {
        // Loop through the submitted data
        foreach ($request->kode_barang as $index => $kode_barang) {
            // Validate each entry
            $validator = Validator::make([
                'kode_barang' => $kode_barang,
                'stock' => $request->stock[$index]
            ], [
                'kode_barang' => 'required|exists:barang,kode_barang',
                'stock' => 'required|numeric|min:1',
            ], [
                'kode_barang.required' => 'Kode barang wajib diisi.',
                'kode_barang.exists' => 'Barang yang dipilih tidak ditemukan.',
                'stock.required' => 'Jumlah stok wajib diisi.',
                'stock.numeric' => 'Jumlah stok harus berupa angka.',
                'stock.min' => 'Jumlah stok minimal 1.',
            ]);

            // If validation fails, return error
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Insert new stock data (even for duplicate kode_barang)
            \DB::table('stock')->insert([
                'kode_barang' => $kode_barang,
                'stock' => $request->stock[$index],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Return success message after processing all items
        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil ditambahkan!'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $decryptedKodeBarang = Crypt::decryptString($id);
            $stock = Stock::where('id', $decryptedKodeBarang)->firstOrFail(); // Use firstOrFail to ensure valid data is returned
            $barangs = Barang::all();

            // Return the view with the stock and barang data
            return view('superadmin.stock.update', compact('stock', 'barangs'));
        } catch (DecryptException $e) {
            return redirect()->route('stock-produk.admin.index')->withErrors('Invalid id.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('stock-produk.admin.index')->withErrors('Stock not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     try {
    //         // Dekripsi kode_barang yang terenkripsi
    //         $decryptedKodeBarang = Crypt::decryptString($id);

    //         // Validasi bahwa semua elemen dalam array stock adalah angka dan minimal 1
    //         $validated = $request->validate([
    //             'stock.*' => 'required|numeric|min:1',  // Menggunakan stock.* untuk validasi setiap elemen input stok dalam array
    //         ], [
    //             'stock.*.required' => 'Jumlah stok wajib diisi.',
    //             'stock.*.numeric' => 'Jumlah stok harus berupa angka.',
    //             'stock.*.min' => 'Jumlah stok minimal 1.',
    //         ]);

    //         // Temukan catatan stok berdasarkan kode_barang yang telah didekripsi
    //         $stock = Stock::where('id', $decryptedKodeBarang)->firstOrFail();

    //         // Perbarui stok dengan nilai pertama dari array stok
    //         $stock->stock = $request->input('stock')[0];  // Menggunakan nilai pertama dari array stok

    //         // Simpan perubahan
    //         $stock->save();

    //         // Kembalikan respons sukses
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Stok berhasil diperbarui!'
    //         ]);
    //     } catch (\Exception $e) {
    //         // Jika terjadi kesalahan, kembalikan respons error
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            // Dekripsi kode_barang yang terenkripsi
            $decryptedKodeBarang = Crypt::decryptString($id);

            // Validasi bahwa semua elemen dalam array stock adalah angka dan minimal 1
            $validated = $request->validate([
                'stock.*' => 'required|numeric|min:1',  // Menggunakan stock.* untuk validasi setiap elemen input stok dalam array
            ], [
                'stock.*.required' => 'Jumlah stok wajib diisi.',
                'stock.*.numeric' => 'Jumlah stok harus berupa angka.',
                'stock.*.min' => 'Jumlah stok minimal 1.',
            ]);

            // Temukan catatan stok berdasarkan kode_barang yang telah didekripsi
            $stock = Stock::where('id', $decryptedKodeBarang)->firstOrFail();

            // Ambil stok lama sebelum perubahan
            $oldStock = $stock->stock;

            // Perbarui stok dengan nilai pertama dari array stok
            $newStock = $request->input('stock')[0]; // Menggunakan nilai pertama dari array stok
            $stock->stock = $newStock;

            // Simpan perubahan stok ke database
            $stock->save();

            // Jika stok lama dan stok baru berbeda, tambahkan entri ke stock_movement sebagai adjustment
            if ($oldStock != $newStock) {
                StockMovement::create([
                    'kode_barang' => $decryptedKodeBarang,
                    'movement_type' => 'adjustment', // Tipe movement adalah adjustment
                    'quantity' => $newStock - $oldStock, // Selisih stok baru dan lama
                    'created_at' => now(), // Waktu saat ini
                    'updated_at' => now(), // Waktu saat ini
                ]);
            }

            // Kembalikan respons sukses
            return response()->json([
                'status' => 'success',
                'message' => 'Stok berhasil diperbarui dan perubahan dicatat sebagai adjustment!'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan respons error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json([
                'status' => 'error',
                'message' => 'Stock Barang tidak ditemukan!'
            ], 404);
        }
        $stock->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Stock Barang berhasil dihapus!'
        ]);
    }
}
