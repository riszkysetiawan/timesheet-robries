<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Warna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\DetailInbound;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\ProdukExport;
use App\Imports\ProdukImport;
use App\Exports\LaporanprodukExport;
use App\Models\Size;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $produks = Produk::with(['kategori', 'warna'])
                ->get();

            return DataTables::of($produks)
                ->addIndexColumn()
                ->addColumn('gambar', function ($produk) {
                    if ($produk->gambar) {
                        return '<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#imageModal' . $produk->kode_produk . '">
                            <img src="' . asset('storage/' . $produk->gambar) . '" alt="Gambar produk" style="width: 50px; height: 50px;">
                        </a>
                        <div class="modal fade" id="imageModal' . $produk->kode_produk . '" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel' . $produk->kode_produk . '" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <img src="' . asset('storage/' . $produk->gambar) . '" alt="Gambar produk" class="img-fluid">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    } else {
                        return 'Tidak ada gambar';
                    }
                })
                // ->addColumn('harga', function ($produk) {
                //     return 'Rp ' . number_format($produk->harga ?? 0, 0, ',', '.');
                // })
                ->addColumn('action', function ($produk) {
                    $editUrl = route('produk.admin.edit', Crypt::encryptString($produk->kode_produk));
                    return '
                    <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                        Edit
                    </a>
                    <a href="javascript:void(0)" onclick="confirmDelete(' . $produk->kode_produk . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
                        Hapus
                    </a>
                ';
                })
                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        return view('superadmin.produk.index');
    }


    public function downloadBarcode($encryptedKodeproduk)
    {
        // Dekripsi kode_produk
        try {
            $kode_produk = Crypt::decryptString($encryptedKodeproduk);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Kode produk tidak valid.');
        }

        // Ambil data produk berdasarkan kode_produk
        $produk = produk::where('kode_produk', $kode_produk)->firstOrFail();

        // Generate barcode menggunakan Picqer\Barcode\BarcodeGeneratorPNG
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = '';

        if (!empty($produk->kode_barcode)) {
            $barcodeImage = 'data:image/png;base64,' . base64_encode(
                $generator->getBarcode($produk->kode_barcode, $generator::TYPE_CODE_128)
            );
        } else {
            return redirect()->back()->with('error', 'Barcode tidak ditemukan.');
        }

        // Generate PDF dengan ukuran kertas 48mm
        $pdf = PDF::loadView('superadmin.barcode.pdf_gambar', compact('produk', 'barcodeImage'))
            ->setPaper([0, 0, 136, 400]); // Ukuran kertas 48mm (136px x tinggi dinamis)

        // Download PDF
        return $pdf->download($produk->kode_produk . '_barcode.pdf');
    }


    public function uploadFile()
    {
        return view('superadmin.produk.upload');
    }
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
        Excel::import(new ProdukImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diupload!'
        ], 200);
    }

    // public function downloadLaporanExcel()
    // {
    //     return Excel::download(new LaporanprodukExport, 'laporan_produk.xlsx');
    // }
    public function downloadLaporan($id)
    {
        // Dekripsi ID
        $decryptedId = Crypt::decryptString($id);

        // Ambil data inbound beserta relasinya
        $produks = produk::with(['kategori', 'satuan', 'stocks', 'wasteStocks', 'detailPurchaseOrders', 'detailPenjualans'])->get();

        // Generate PDF dari view yang berisi data inbound
        $pdf = PDF::loadView('superadmin.laporan.produk_pdf', ['produks' => $produks]);

        // Return file PDF untuk di-download
        return $pdf->download('laporan_produk' . '.pdf');
    }

    // public function laporan(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $produks = Produk::with(['kategori', 'warna', 'stock'])->get();

    //         return DataTables::of($produks)
    //             ->addIndexColumn()
    //             ->addColumn('kategori', function ($produk) {
    //                 return $produk->kategori ? $produk->kategori->nama_kategori : 'Tidak Ada';
    //             })
    //             ->addColumn('warna', function ($produk) {
    //                 return $produk->satuan ? $produk->satuan->satuan : 'Tidak Ada';
    //             })
    //             ->addColumn('stock', function ($produk) {
    //                 return $produk->stocks->sum('stock') ?? 0;
    //             })
    //             ->addColumn('jumlah_waste', function ($produk) {
    //                 return $produk->wasteStocks->sum('waste') ?? 0;
    //             })
    //             ->addColumn('jumlah_keluar', function ($produk) {
    //                 return $produk->detailPenjualans->sum('qty') ?? 0;
    //             })
    //             ->addColumn('jumlah_masuk', function ($produk) {
    //                 return $produk->detailPurchaseOrders->sum('qty') ?? 0;
    //             })
    //             ->make(true);
    //     }

    //     return view('superadmin.laporan.produk');
    // }
    public function downloadExcel()
    {
        return Excel::download(new ProdukExport, 'produks.xlsx');
    }

    public function downloadPdf()
    {
        $produks = produk::with('kategori', 'satuan', 'stocks')->get();
        $pdf = PDF::loadView('superadmin.produk.pdf', ['produks' => $produks])
            ->setPaper('A4', 'portrait')
            ->setOptions(['margin-left' => 15, 'margin-right' => 15, 'margin-top' => 15, 'margin-bottom' => 15]);

        return $pdf->download('produks.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $warnas = Warna::all();
        $sizes = Size::all();

        return view('superadmin.produk.create', compact('kategoris', 'warnas', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'kode_produk' => 'required|string|max:255|unique:produk,kode_produk',
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'kode_barcode' => 'nullable|string|max:255',
            // 'harga' => 'required|string|max:255',
            // 'keterangan' => 'nullable|string|max:255',
            // 'id_kategori' => 'nullable|exists:kategori_barang,id',
            'id_size' => 'nullable|exists:size,id',
            'id_warna' => 'nullable|exists:warna,id',
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.string' => 'Kode produk harus berupa teks.',
            'kode_produk.max' => 'Kode produk tidak boleh lebih dari 255 karakter.',
            'kode_produk.unique' => 'Kode produk sudah terdaftar, gunakan kode lain.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            // 'harga.required' => 'Harga wajib diisi.',
            // 'harga.string' => 'Harga harus berupa teks.',
            // 'keterangan.string' => 'Keterangan harus berupa teks.',
            // 'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
            // 'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'id_warna.exists' => 'Warna yang dipilih tidak valid.',
            'id_size.exists' => 'Ukuran yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Menyimpan data produk ke dalam database
        $produk = new Produk();
        $produk->kode_produk = $request->kode_produk;
        $produk->nama_barang = $request->nama_barang;
        // $produk->kode_barcode = $request->kode_barcode;
        // $produk->harga = $request->harga;
        // $produk->keterangan = $request->keterangan;
        $produk->id_size = $request->id_size;
        // $produk->id_kategori = $request->id_kategori;
        $produk->id_warna = $request->id_warna;

        // Jika ada file gambar yang di-upload
        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $filePath = $request->file('gambar')->storeAs('public/photos', $imageName);
            $produk->gambar = 'photos/' . $imageName;
        }

        $produk->save();

        // Mengirimkan response sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $produk = produk::findOrFail($decryptedId);
        $kategoris = Kategori::all();
        $warnas = Warna::all();
        $sizes = Size::all();

        return view('superadmin.produk.update', compact('produk', 'kategoris', 'warnas', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Mendekripsi ID yang terenkripsi
        $decryptedId = Crypt::decryptString($id);

        // Validasi input request
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_barcode' => 'nullable|string|max:255',
            // 'harga' => 'required|string|max:255',
            // 'keterangan' => 'nullable|string|max:255',
            // 'id_kategori' => 'nullable|exists:kategori_barang,id',
            'id_warna' => 'nullable|exists:warna,id',
            'id_size' => 'nullable|exists:size,id',
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            // 'kode_barcode.string' => 'Kode barcode harus berupa teks.',
            // 'kode_barcode.max' => 'Kode barcode tidak boleh lebih dari 255 karakter.',
            // 'harga.required' => 'Harga wajib diisi.',
            // 'harga.string' => 'Harga harus berupa teks.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
            // 'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'id_warna.exists' => 'Warna yang dipilih tidak valid.',
            'id_size.exists' => 'Ukuran yang dipilih tidak valid.',
        ]);

        // Jika validasi gagal, kirim response error
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Mencari produk berdasarkan ID yang terenkripsi
        $produk = Produk::findOrFail($decryptedId);

        // Update data produk dengan data request
        $produk->nama_barang = $request->nama_barang;
        // $produk->kode_barcode = $request->kode_barcode;
        // $produk->harga = $request->harga;
        // $produk->keterangan = $request->keterangan;
        // $produk->id_kategori = $request->id_kategori;
        $produk->id_warna = $request->id_warna;
        $produk->id_size = $request->id_size;

        // Jika ada file gambar yang di-upload, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::delete('public/' . $produk->gambar);
            }

            // Simpan gambar baru
            $imageName = time() . '.' . $request->gambar->extension();
            $filePath = $request->file('gambar')->storeAs('public/produk', $imageName);
            $produk->gambar = 'produk/' . $imageName;
        }

        // Simpan perubahan data produk
        $produk->save();

        // Mengirimkan response sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk tidak ditemukan!'
            ], 404);
        }
        if ($produk->foto) {
            $filePath = storage_path('app/public/' . $produk->foto);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        $produk->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'produk berhasil dihapus!'
        ]);
    }
}
