<?php

namespace App\Http\Controllers\Admin;

use App\Models\Production;
use App\Http\Requests\StoreProductionRequest;
use App\Http\Requests\UpdateProductionRequest;
use App\Models\Produk;
use App\Models\DetailProduction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Warna;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use App\Exports\ProductionExport;
use App\Models\Proses;
use App\Models\Size;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dari tabel production beserta timers dan proses
            $productions = Production::with(['timers.proses', 'timers.user'])
                ->orderBy('created_at', 'desc')
                ->select('production.*'); // Pastikan mengambil data dari production table

            // Filter berdasarkan tanggal jika ada
            if ($request->has('startDate') && $request->has('endDate')) {
                $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
                $endDate = Carbon::parse($request->input('endDate'))->endOfDay();
                $productions = $productions->whereBetween('created_at', [$startDate, $endDate]);
            }

            return DataTables::of($productions)
                ->addIndexColumn() // Menambahkan index untuk DataTables
                ->addColumn('action', function ($row) {
                    $editUrl = route('production.admin.edit', Crypt::encryptString($row->so_number));
                    $detailUrl = route('detail.production.admin', Crypt::encryptString($row->so_number));
                    return '
                        <a href="' . $editUrl . '" class="btn btn-outline-primary">Edit</a>
                        <a href="' . $detailUrl . '" class="btn btn-outline-info">Detail</a>';
                })
                // Kolom untuk masing-masing waktu proses dan operator
                ->addColumn('oven_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 1); // Oven Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('oven_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 1); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })

                ->addColumn('oven_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 2); // Oven Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('oven_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 2); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('press_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 3); // Press Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('press_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 3); // Press Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('press_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 4); // Press Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('press_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 4); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('wbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 5); // WBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('wbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 5); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('wbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 6); // WBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('wbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 6); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('weld_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 7); // WELD Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('weld_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 7); // WELD Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('weld_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 8); // WELD Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('weld_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 8); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('vbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 9); // VBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('vbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 9); // VBS Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('vbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 10); // VBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('vbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 10); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('hbs_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 11); // HBS Start
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('hbs_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 11); // HBS Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('hbs_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 12); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('hbs_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 12); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('poles_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 13); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('poles_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 13); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('poles_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 14); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('poles_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 14); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('assembly_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 15); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('assembly_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 15); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('assembly_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 16); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('assembly_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 16); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('finishing_start', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 17); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('finishing_start_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 17); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('finishing_finish', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 18); // HBS Finish
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('finishing_finish_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 18); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('finish_rework', function ($row) {
                    $timer = $row->timers->firstWhere('id_proses', 19); // Finish Rework
                    return $timer ? \Carbon\Carbon::parse($timer->waktu)->format('Y-m-d H:i:s') : '-';
                })
                ->addColumn('finish_rework_operator', function ($row) {
                    $operators = $row->timers->where('id_proses', 19); // Oven Start
                    $operatorNames = $operators->map(function ($timer) {
                        return $timer->user ? $timer->user->nama : '-';
                    });
                    return $operatorNames->implode(', '); // Menggabungkan nama operator dengan koma
                })
                ->addColumn('progress', function ($row) {
                    $progress = $row->timers->where('status', 'progress')->count();
                    return $progress ? $progress . ' %' : '0 %';
                })
                ->make(true);
        }

        return view('superadmin.production.index');
    }





    // public function downloadLaporan($id)
    // {
    //     $decryptedId = Crypt::decryptString($id);
    //     $productions = Production::with('detailProductions')->findOrFail($decryptedId);
    //     $produks = Produk::all();
    //     $warna = Warna::all();
    //     $productions = Penjualan::with('detailProductions.produk')->findOrFail($decryptedId);
    //     $pdf = PDF::loadView('superadmin.laporan.penjualan_pdf', ['penjualan' => $penjualan, 'profile' => $profile, 'penjualans' => $penjualans]);
    //     return $pdf->download('penjualan_' . $penjualan->kode_invoice . '.pdf');
    // }
    // PenjualanController.php
    public function preview($id)
    {
        // Mengambil data penjualan beserta detailnya
        $production = Production::with('detailProductions.barang')->findOrFail($id);

        return response()->json([
            'production' => $production,
            'details' => $production->detailProductions
        ]);
    }

    public function downloadExcel(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        return Excel::download(new  ProductionExport($startDate, $endDate), 'penjualans.xlsx');
    }

    public function getBarangByBarcode($barcode)
    {
        // Cari barang berdasarkan barcode
        $produk = Produk::with('warna')->where('kode_barcode', $barcode)->first();

        if ($produk) {
            return response()->json([
                'kode_produk' => $produk->kode_produk,
                'harga' => $produk->harga,
                'warna' => $produk->warna->warna
            ]);
        }

        return response()->json(null);
    }

    // public function generatePDF($id)
    // {
    //     try {
    //         $decryptedId = Crypt::decryptString($id);
    //         $penjualans = Penjualan::with('detailPenjualans')->findOrFail($decryptedId);
    //         $barangs = Barang::all();
    //         $satuans = SatuanBarang::all();
    //         $profile = ProfileCompany::first();
    //         $pdf = PDF::loadView('superadmin.penjualan.pdf', compact('penjualans', 'barangs', 'satuans', 'profile'));
    //         $fileName = 'invoice-' . $penjualans->kode_invoice . '.pdf';
    //         Storage::put('public/pdfs/' . $fileName, $pdf->output());
    //         return response()->json([
    //             'status' => 'success',
    //             'url' => Storage::url('public/pdfs/' . $fileName),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => 'Unable to generate PDF.'], 500);
    //     }
    // }
    public function getProduk($kode_produk)
    {
        $produk = Produk::with('warna')->where('kode_produk', $kode_produk)->first();

        if ($produk) {
            return response()->json([
                'produk' => $produk,
                'warna' => $produk->warna->warna // Kirim data satuan juga
            ]);
        } else {
            return response()->json(['message' => 'produk tidak ditemukan'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::all();
        $warnas = Warna::all();
        $prosess = Proses::all();
        $sizes = Size::all();
        return view('superadmin.production.create', compact('produks', 'warnas', 'sizes', 'prosess'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'so_number.*' => 'required',
            'tgl_production' => 'required|date',
            'kode_produk.*' => 'required|exists:produk,kode_produk', // Pastikan kode produk ada di tabel produk
            'qty.*' => 'required|numeric|min:1',
            'warna.*' => 'required|string',
            'size.*' => 'required|string',
            'barcode.*' => 'required|string',
            'id_proses.*' => 'required|exists:proses,id',
        ], [
            // Pesan validasi seperti sebelumnya
        ]);

        try {
            DB::beginTransaction();

            // Ambil ID User dari sesi login
            $id_user = Auth::id();

            // Simpan data ke tabel production
            foreach ($request->so_number as $key => $so_number) {
                // Simpan setiap data sebagai satu row di tabel production
                $production = new Production();
                $production->so_number = $so_number;
                $production->tgl_production = $request->tgl_production;
                $production->size = $request->size[$key];
                $production->color = $request->warna[$key];
                $production->qty = $request->qty[$key];
                $production->barcode = $request->barcode[$key];
                $production->kode_produk = $request->kode_produk[$key]; // Setiap item dari array
                $production->finish_rework = null;
                $production->progress = null;
                $production->save();
            }

            // Commit Transaksi
            DB::commit();

            // Enkripsi SO Number
            $encryptedSoNumber = Crypt::encryptString($request->so_number[0]);

            // Kembalikan Response JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan!',
                'encrypted_so_number' => $encryptedSoNumber,
            ]);
        } catch (\Exception $e) {
            // Rollback Transaksi jika Ada Error
            DB::rollBack();

            // Logging Error
            \Log::error('Error saat menyimpan data production: ' . $e->getMessage());

            // Kembalikan Response Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $production = Production::with('detailProductions')->findOrFail($id);
            $produks = Produk::all();
            $warnas = Warna::all();
            return view('superadmin.production.detail', compact('produks', 'produks', 'warnas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $productions = Production::with('detailProductions')->findOrFail($id);
            $produks = Produk::all();
            $warnas = Warna::all();
            return view('superadmin.production.update', compact('productions', 'produks', 'warnas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $encryptedId)
    {
        try {
            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);

            $request->validate([
                // Bagian yang wajib diisi
                'so_number' => 'required|unique:production,so_number',
                'tgl_production' => 'required|date',
                'kode_produk.*' => 'required|exists:produk,kode_produk',
                'qty.*' => 'required|numeric|min:1',
                'color.*' => 'required|string',
                'size.*' => 'required|string',
                'barcode.*' => 'required|string',
                'progress.*' => 'required|string',
            ], [
                // Pesan error untuk input yang wajib
                'so_number.required' => 'SO Number wajib diisi.',
                'so_number.unique' => 'SO Number sudah terdaftar.',
                'tgl_production.required' => 'Tanggal produksi wajib diisi.',
                'tgl_production.date' => 'Format tanggal produksi tidak valid.',
                'kode_produk.*.required' => 'Kode produk wajib diisi.',
                'kode_produk.*.exists' => 'Kode produk tidak ditemukan di database.',
                'qty.*.required' => 'Jumlah barang (Qty) wajib diisi.',
                'qty.*.numeric' => 'Jumlah barang (Qty) harus berupa angka.',
                'qty.*.min' => 'Jumlah barang (Qty) tidak boleh kurang dari 1.',
                'color.*.required' => 'Kolom warna wajib diisi.',
                'size.*.required' => 'Kolom ukuran wajib diisi.',
                'barcode.*.required' => 'Kolom barcode wajib diisi.',
                'progress.*.required' => 'Kolom progress wajib diisi.',
            ]);


            // Mulai Transaksi
            DB::beginTransaction();
            // Ambil Data Production
            $production = Production::findOrFail($id);
            $production->so_number = $request->so_number;
            $production->tgl_production = $request->tgl_production;
            $production->save();
            // Hapus Detail Lama
            $production->detailProductions()->delete();
            // Tambahkan Detail Baru
            foreach ($request->kode_produk as $index => $kode_produk) {
                $detailProduction = new DetailProduction();
                $detailProduction->so_number = $production->so_number;
                $detailProduction->kode_produk = $kode_produk;
                $detailProduction->qty = $request->qty[$index];
                $detailProduction->color = $request->color[$index] ?? null;
                $detailProduction->size = $request->size[$index] ?? null;
                $detailProduction->barcode = $request->barcode[$index] ?? null;
                $detailProduction->progress = $request->progress[$index] ?? null;
                $detailProduction->save();
            }

            // Commit Transaksi
            DB::commit();

            // Enkripsi SO Number
            $encryptedSoNumber = Crypt::encryptString($production->so_number);

            // Kembalikan Response JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate!',
                'encrypted_so_number' => $encryptedSoNumber,
            ]);
        } catch (\Exception $e) {
            // Rollback Transaksi jika Ada Error
            DB::rollBack();

            // Logging Error
            \Log::error('Error saat update SO: ' . $e->getMessage());

            // Kembalikan Response Error
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $production = Production::findOrFail($id);
                DetailProduction::where('kode_so', $penjualan->kode_so)->delete();
                $penjualan->delete();
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Penjualan Order berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus Production : ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus Penjualan.'
            ], 500);
        }
    }
}
