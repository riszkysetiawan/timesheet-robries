<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BarangExport;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\KategoriBarang;
use App\Models\SatuanBarang;
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
use App\Models\Kategori;

use function Ramsey\Uuid\v1;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $barangs = Barang::with(['kategori', 'satuan', 'stocks', 'wasteStocks'])
                ->get()
                ->map(function ($barang) {
                    $barang->stocks_sum_stock = $barang->stocks->sum('stock');
                    $barang->wasteStocks_sum_waste = $barang->wasteStocks->sum('waste');
                    return $barang;
                });

            return DataTables::of($barangs)
                ->addIndexColumn()
                ->addColumn('action', function ($barang) {
                    $editUrl = route('barang.admin.edit', Crypt::encryptString($barang->kode_barang));
                    return '
                    <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                        <i class="feather feather-edit"></i> Edit
                    </a>
                    <a href="javascript:void(0)" onclick="confirmDelete(\'' . $barang->kode_barang . '\')"
                        class="btn btn-outline-danger btn-rounded mb-2 me-4">
                        <i class="feather feather-trash-2"></i> Hapus
                    </a>
                    ';
                })
                ->rawColumns(['action']) // Mengizinkan kolom action untuk HTML
                ->make(true);
        }

        return view('superadmin.barang.index');
    }


    public function downloadBarcode($encryptedKodeBarang)
    {
        // Dekripsi kode_barang
        try {
            $kode_barang = Crypt::decryptString($encryptedKodeBarang);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->with('error', 'Kode barang tidak valid.');
        }

        // Ambil data barang berdasarkan kode_barang
        $barang = Barang::where('kode_barang', $kode_barang)->firstOrFail();

        // Generate barcode menggunakan Picqer\Barcode\BarcodeGeneratorPNG
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = '';

        if (!empty($barang->kode_barcode)) {
            $barcodeImage = 'data:image/png;base64,' . base64_encode(
                $generator->getBarcode($barang->kode_barcode, $generator::TYPE_CODE_128)
            );
        } else {
            return redirect()->back()->with('error', 'Barcode tidak ditemukan.');
        }

        // Generate PDF dengan ukuran kertas 48mm
        $pdf = PDF::loadView('superadmin.barcode.pdf_gambar', compact('barang', 'barcodeImage'))
            ->setPaper([0, 0, 136, 400]); // Ukuran kertas 48mm (136px x tinggi dinamis)

        // Download PDF
        return $pdf->download($barang->kode_barang . '_barcode.pdf');
    }
    public function printBarcode($encryptedKodeBarang)
    {
        try {
            $kode_barang = Crypt::decryptString($encryptedKodeBarang);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Kode barang tidak valid.'], 400);
        }

        $barang = Barang::where('kode_barang', $kode_barang)->firstOrFail();

        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = '';
        if (!empty($barang->kode_barcode)) {
            $barcodeImage = 'data:image/png;base64,' . base64_encode(
                $generator->getBarcode($barang->kode_barcode, $generator::TYPE_CODE_128)
            );
        } else {
            return response()->json(['error' => 'Barcode tidak ditemukan.'], 400);
        }

        // Mengembalikan view sebagai response
        return view('superadmin.barcode.pdf_gambar', compact('barang', 'barcodeImage'));
    }

    public function uploadFile()
    {
        return view('superadmin.barang.upload');
    }
    public function uploadExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:20480' // 20MB = 20480KB
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
        Excel::import(new BarangImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data barang berhasil diupload!'
        ], 200);
    }

    public function downloadLaporanExcel()
    {
        return Excel::download(new LaporanBarangExport, 'laporan_barang.xlsx');
    }
    public function downloadLaporan($id)
    {
        // Dekripsi ID
        $decryptedId = Crypt::decryptString($id);

        // Ambil data inbound beserta relasinya
        $barangs = Barang::with(['kategori', 'satuan', 'stocks', 'wasteStocks', 'detailPurchaseOrders', 'detailPenjualans'])->get();

        // Generate PDF dari view yang berisi data inbound
        $pdf = PDF::loadView('superadmin.laporan.barang_pdf', ['barangs' => $barangs]);

        // Return file PDF untuk di-download
        return $pdf->download('laporan_barang' . '.pdf');
    }

    public function downloadExcel()
    {
        return Excel::download(new BarangExport, 'barangs.xlsx');
    }

    public function downloadPdf()
    {
        $barangs = Barang::with('kategori', 'satuan', 'stocks', 'wasteStocks')->get();
        $pdf = PDF::loadView('superadmin.barang.pdf', ['barangs' => $barangs])
            ->setPaper('A4', 'portrait')
            ->setOptions(['margin-left' => 15, 'margin-right' => 15, 'margin-top' => 15, 'margin-bottom' => 15]);

        return $pdf->download('barangs.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $satuans = SatuanBarang::all();

        return view('superadmin.barang.create', compact('kategoris', 'satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required|string|max:255|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barang,id',
            'id_satuan' => 'required|exists:satuan_barang,id',
            'type' => 'nullable|string|in:Standard,Special Color', // Validasi type
        ], [
            // Pesan error untuk kode_barang
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.string' => 'Kode barang harus berupa teks.',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 255 karakter.',
            'kode_barang.unique' => 'Kode barang sudah terdaftar, gunakan kode lain.',

            // Pesan error untuk nama_barang
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',

            // Pesan error untuk id_kategori
            'id_kategori.required' => 'Kategori barang wajib dipilih.',
            'id_kategori.exists' => 'Kategori barang yang dipilih tidak valid.',

            // Pesan error untuk id_satuan
            'id_satuan.required' => 'Satuan barang wajib dipilih.',
            'id_satuan.exists' => 'Satuan barang yang dipilih tidak valid.',

            // Pesan error untuk type
            'type.in' => 'Tipe hanya dapat berupa "Standard" atau "Special Color".',
            'type.string' => 'Tipe harus berupa teks.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek kategori berdasarkan id
        $kategori = Kategori::find($request->id_kategori);

        // Logika untuk input Type
        $typeValue = null;
        if ($kategori && $kategori->nama_kategori === 'Raw Material') {
            $typeValue = $request->type; // Hanya ambil jika kategori Raw Material
        }

        $barang = new Barang();
        $barang->kode_barang = $request->kode_barang;
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;
        $barang->type = $typeValue; // Simpan Type hanya jika Raw Material

        $barang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $barang = Barang::with(['stocks', 'wasteStocks'])->findOrFail($decryptedId);
        $kategoris = Kategori::all();
        $satuans = SatuanBarang::all();

        return view('superadmin.barang.update', compact('barang', 'kategoris', 'satuans'));
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_barang,id',
            'id_satuan' => 'required|exists:satuan_barang,id',
            'stocks' => 'nullable|array',
            'stocks.*' => 'nullable|numeric|min:0',
        ], [
            // Pesan Error Bahasa Indonesia
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.string' => 'Nama barang harus berupa teks.',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter.',

            'id_kategori.required' => 'Kategori barang wajib dipilih.',
            'id_kategori.exists' => 'Kategori barang yang dipilih tidak valid.',

            'id_satuan.required' => 'Satuan barang wajib dipilih.',
            'id_satuan.exists' => 'Satuan barang yang dipilih tidak valid.',

            'stocks.array' => 'Data stok harus berupa array yang valid.',
            'stocks.*.numeric' => 'Setiap stok harus berupa angka.',
            'stocks.*.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        // Cek validasi
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data barang
        $barang = Barang::findOrFail($decryptedId);
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->id_satuan = $request->id_satuan;

        $barang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil diupdate!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json([
                'status' => 'error',
                'message' => 'barang tidak ditemukan!'
            ], 404);
        }
        $barang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'barang berhasil dihapus!'
        ]);
    }
}
