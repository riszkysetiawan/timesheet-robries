<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Inbound;
use App\Http\Requests\StoreInbondRequest;
use App\Http\Requests\UpdateInbondRequest;
use App\Exports\InboundExport;
use App\Models\Barang;
use App\Models\CompanyProfile;
use App\Models\DetailInbond;
use App\Models\Supplier;
use App\Models\ProfileCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SatuanBarang;
use Illuminate\Support\Facades\Crypt;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use App\Models\DetailInbound;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Log;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class InbondController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function downloadLaporan($id)
    {
        // Dekripsi ID
        $decryptedId = Crypt::decryptString($id);

        // Ambil data inbound beserta relasinya
        // $inbound = Inbound::with('supplier', 'details.barang')->findOrFail($decryptedId);
        $purchaseOrder = Inbound::with([
            'details.barang',
            'purchaseOrder',
            'supplier',
            'purchaseOrder.details.barang'
        ])->findOrFail($decryptedId);

        // Memuat data tambahan
        $profile = CompanyProfile::first();
        $pembelian = PurchaseOrder::where('kode_po', $purchaseOrder->kode_po)->first();
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $satuans = SatuanBarang::all();

        $pdf = PDF::loadView('superadmin.laporan.inbound_pdf', [
            'purchaseOrder' => $purchaseOrder,
            'profile' => $profile,
            'pembelian' => $pembelian,
            'suppliers' => $suppliers,
            'barangs' => $barangs,
            'satuans' => $satuans
        ]);

        // Return file PDF untuk di-download
        return $pdf->download('inbound_' . $purchaseOrder->kode_po . '.pdf');
    }


    public function preview($id)
    {
        $inbound = Inbound::with(['purchaseOrder', 'details.barang', 'supplier'])->findOrFail($id);

        return response()->json([
            'inbound' => $inbound,
            'details' => $inbound->details
        ]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query dengan filter tanggal
            $inbounds = Inbound::with(['supplier', 'details.barang'])
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('eta', [$startDate, $endDate]);
                })
                ->get();
            // Ambil data dan kembalikan dalam bentuk JSON untuk DataTables
            return DataTables::of($inbounds)
                ->addIndexColumn() // Menambahkan kolom indeks otomatis
                ->addColumn('supplier_name', function ($inbound) {
                    return $inbound->supplier ? $inbound->supplier->nama_supplier : 'Tidak Ada Supplier';
                })
                ->addColumn('status', function ($inbound) {
                    return $inbound->purchaseOrder ? $inbound->purchaseOrder->status : 'Tidak Ada Status';
                })
                ->addColumn('action', function ($inbound) {
                    $editUrl = route('inbound.admin.edit', Crypt::encryptString($inbound->kode_po));
                    $detailUrl = route('detail.inbond.admin', Crypt::encryptString($inbound->kode_po));

                    return '
                        <!-- Tombol Hapus -->
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(\'' . $inbound->kode_po . '\')" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Hapus
                        </a>

                        <!-- Tombol Edit -->
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>

                        <!-- Tombol Preview -->
                        <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview" data-id="' . $inbound->kode_po . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M21 12c-2.25 4.5-6.75 4.5-9 0s-6.75-4.5-9 0"></path>
                            </svg>
                            Preview
                        </button>

                        <!-- Tombol Detail -->
                        <a href="' . $detailUrl . '" class="btn btn-outline-info btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 5v2"></path>
                                <path d="M12 15v2"></path>
                            </svg>
                            Detail
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.inbound.index');
    }

    public function downloadExcel(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        return Excel::download(new InboundExport($startDate, $endDate), 'inbound_' . now()->format('Ymd_His') . '.xlsx');
    }
    public function laporan(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query dengan filter tanggal
            $inbounds = Inbound::with(['supplier', 'details.barang'])
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('eta', [$startDate, $endDate]);
                })
                ->get();

            return DataTables::of($inbounds)
                ->addIndexColumn()
                ->addColumn('supplier_name', function ($inbound) {
                    return $inbound->supplier ? $inbound->supplier->nama_supplier : 'Tidak Ada Supplier';
                })
                ->addColumn('status', function ($inbound) {
                    return $inbound->purchaseOrder ? $inbound->purchaseOrder->status : 'Tidak Ada Status';
                })
                ->addColumn('action', function ($inbound) {
                    $kodePo = Crypt::encryptString($inbound->kode_po);

                    // Tombol Preview
                    $previewButton = '
                        <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview" data-id="' . $inbound->kode_po . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M21 12c-2.25 4.5-6.75 4.5-9 0s-6.75-4.5-9 0"></path>
                            </svg>
                            Preview
                        </button>';

                    // Tombol Download PDF
                    $downloadButton = '
                        <a href="' . route('download.laporan.inbond.admin.pdf', $kodePo) . '" class="btn btn-outline-success btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download PDF
                        </a>';

                    // Tombol Detail
                    $detailButton = '
                        <a href="' . route('detail.inbond.admin', $kodePo) . '" class="btn btn-outline-info btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 5v2"></path>
                                <path d="M12 15v2"></path>
                            </svg>
                            Detail
                        </a>';

                    return $previewButton . $downloadButton . $detailButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.laporan.inbond');
    }


    public function edits($id)
    {
        try {
            // Check what $id looks like before decryption
            Log::info('Encrypted kode_po: ' . $id);

            // Decrypt the kode_po
            $decryptedId = Crypt::decryptString($id);

            // Log the decrypted result
            Log::info('Decrypted kode_po: ' . $decryptedId);

            // Fetch the purchase order
            $inbond = Inbound::with('details')->findOrFail($decryptedId);

            $suppliers = Supplier::all();
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $profile = CompanyProfile::first();

            return view('superadmin.inbound.update', compact('inbond', 'suppliers', 'barangs', 'satuans', 'profile'));
        } catch (\Exception $e) {
            Log::error('Error in editing inbound: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }
    public function generatePDF($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $purchaseOrder = Inbound::with([
                'details.barang',
                'purchaseOrder',
                'purchaseOrder.details.barang'
            ])->findOrFail($id);
            $profile = CompanyProfile::first();
            $pembelian = PurchaseOrder::where('kode_po', $purchaseOrder->kode_po)->first();
            $suppliers = Supplier::all();
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $pdf = PDF::loadView('superadmin.inbound.pdf', compact('purchaseOrder', 'suppliers', 'barangs', 'satuans', 'profile', 'pembelian'));
            return $pdf->download('Invoice-' . $purchaseOrder->kode_po . '.pdf');
        } catch (\Exception $e) {
            return back()->withErrors('Error: ' . $e->getMessage());
        }
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
        // Validasi langsung tanpa memanggil fails()
        $validatedData = $request->validate([
            'kode_po' => 'required|string',
            'id_supplier' => 'required|exists:supplier,id',
            'tgl_kedatangan' => 'required|date',
            'kode_barang.*' => 'required|exists:barang,kode_barang',
            'qty.*' => 'required|integer|min:1',
            'qty_actual.*' => 'required|integer|min:0',
            'reject.*' => 'nullable|integer|min:0',
            'final_qty.*' => 'required|integer|min:0',
            'keterangan.*' => 'nullable|string',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'satuan.*' => 'required|string',
            'status' => 'required|string',
        ], [
            'kode_po.required' => 'Kode PO wajib diisi.',
            'status.required' => 'Status Wajib Diisi.',
            'id_supplier.required' => 'Silakan pilih supplier yang valid.',
            'tgl_kedatangan.required' => 'Tanggal Kedatangan Wajib Diisi.',
            'kode_barang.*.exists' => 'Barang yang dipilih tidak tersedia.',
            'qty.*.required' => 'Jumlah PO wajib diisi.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
            'qty_actual.*.required' => 'Jumlah aktual wajib diisi.',
            'reject.*.integer' => 'Jumlah reject wajib angka.',
            'final_qty.*.required' => 'Jumlah final wajib diisi.',
            'satuan.*.required' => 'Satuan wajib diisi.',
            'status.required' => 'Status wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            // Membuat entri baru di tabel inbound
            $inbound = Inbound::create([
                'kode_po' => $validatedData['kode_po'],
                'id_supplier' => $validatedData['id_supplier'],
                'tgl_kedatangan' => $validatedData['tgl_kedatangan'],
                'catatan' => $request->catatan ?? null,
            ]);

            // Loop untuk setiap barang yang diterima
            foreach ($validatedData['kode_barang'] as $index => $kode_barang) {
                $imagePath = null;
                if ($request->hasFile('gambar')) {
                    $image = $request->file('gambar')[$index];
                    $imagePath = $image->store('uploads', 'public');
                }

                // Menyimpan detail barang yang diterima
                DetailInbond::create([
                    'kode_po' => $inbound->kode_po,
                    'kode_barang' => $kode_barang,
                    'qty_po' => $validatedData['qty'][$index],
                    'qty_actual' => $validatedData['qty_actual'][$index],
                    'reject' => $validatedData['reject'][$index] ?? 0,
                    'final_qty' => $validatedData['final_qty'][$index],
                    'keterangan' => $validatedData['keterangan'][$index],
                    'satuan' => $validatedData['satuan'][$index],
                    'gambar' => $imagePath,
                ]);

                // Jika status diterima, update stok dan catat stock movement
                if ($validatedData['status'] === 'Diterima') {
                    $stock = Stock::where('kode_barang', $kode_barang)->first();

                    if ($stock) {
                        // Update stock yang ada
                        $stock->stock += $validatedData['final_qty'][$index];
                        $stock->save();
                    } else {
                        // Jika tidak ada, buat stok baru
                        Stock::create([
                            'kode_barang' => $kode_barang,
                            'stock' => $validatedData['final_qty'][$index],
                        ]);
                    }

                    // Catat pergerakan stok "in" pada tabel stock_movement
                    StockMovement::create([
                        'kode_barang' => $kode_barang,
                        'movement_type' => 'in',
                        'quantity' => $validatedData['final_qty'][$index],
                    ]);
                }
            }

            // Update status pada Purchase Order
            $purchaseOrder = PurchaseOrder::where('kode_po', $validatedData['kode_po'])->first();
            if ($purchaseOrder) {
                $purchaseOrder->status = $validatedData['status'];
                $purchaseOrder->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan dan status PO diperbarui.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Menangani exception dengan menampilkan error spesifik
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                'exception' => $e->getTraceAsString(),  // Ini akan memberikan lebih banyak detail terkait error
            ], 500);
        }
    }

    public function getBarang($kode_barang)
    {
        $barang = Barang::where('kode_barang', $kode_barang)->first();

        if ($barang) {
            return response()->json($barang);
        } else {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $purchaseOrder = Inbound::with([
                'details.barang',
                'purchaseOrder',
                'purchaseOrder.details.barang'
            ])->findOrFail($id);
            $pembelian = PurchaseOrder::where('kode_po', $id)->first();
            $suppliers = Supplier::all();
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $profile = ProfileCompany::first();
            return view('superadmin.inbound.detail', compact('purchaseOrder', 'suppliers', 'barangs', 'satuans', 'profile', 'pembelian'));
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
            $purchaseOrder = PurchaseOrder::with('details')->findOrFail($id);
            $suppliers = Supplier::all();
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $profile = CompanyProfile::first();
            return view('superadmin.inbound.terima', compact('purchaseOrder', 'suppliers', 'barangs', 'satuans', 'profile'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }
    public function getSupplier($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            return response()->json($supplier);
        } else {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $request->validate([
                'id_supplier' => 'required|exists:supplier,id',
                'exp.*' => 'nullable|date',
                'eta' => 'required|date',
                'catatan' => 'nullable|string',
                'kode_po' => 'required|string',
                'keterangan.*' => 'nullable|string',
                'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kode_barang.*' => 'required|exists:barang,kode_barang',
                'qty_po.*' => 'required|numeric|min:1',
                'final_qty.*' => 'required|numeric|min:0',
                'qty_actual.*' => 'required|numeric|min:0',
                'reject.*' => 'nullable|numeric|min:0',
            ], [
                'id_supplier.required' => 'Supplier harus dipilih.',
                'id_supplier.exists' => 'Supplier yang dipilih tidak valid.',
                'exp.*.date' => 'Format tanggal exp tidak valid.',
                'eta.required' => 'Estimasi waktu kedatangan (ETA) wajib diisi.',
                'eta.date' => 'Format ETA tidak valid.',
                'kode_po.required' => 'Kode PO wajib diisi.',
                'gambar.*.image' => 'Gambar harus berupa file gambar.',
                'gambar.*.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
                'gambar.*.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
                'keterangan.*.string' => 'Keterangan harus berupa teks.',
                'kode_barang.*.required' => 'Kode barang untuk setiap item wajib diisi.',
                'kode_barang.*.exists' => 'Kode barang yang dipilih tidak valid.',
                'qty_po.*.required' => 'Jumlah PO untuk setiap item wajib diisi.',
                'qty_po.*.numeric' => 'Jumlah PO harus berupa angka.',
                'qty_po.*.min' => 'Jumlah PO minimal adalah 1.',
                'final_qty.*.required' => 'Jumlah final untuk setiap item wajib diisi.',
                'final_qty.*.numeric' => 'Jumlah final harus berupa angka.',
                'final_qty.*.min' => 'Jumlah final minimal adalah 0.',
                'qty_actual.*.required' => 'Jumlah aktual untuk setiap item wajib diisi.',
                'qty_actual.*.numeric' => 'Jumlah aktual harus berupa angka.',
                'qty_actual.*.min' => 'Jumlah aktual minimal adalah 0.',
                'reject.*.numeric' => 'Jumlah reject harus berupa angka.',
                'reject.*.min' => 'Jumlah reject minimal adalah 0.',
            ]);
            $inbound = Inbound::findOrFail($id);
            $inbound->update([
                'id_supplier' => $request->id_supplier,
                'eta' => $request->eta,
                'catatan' => $request->catatan,
            ]);
            $detailInboundLama = $inbound->details()->get();
            $inbound->details()->delete();
            if (is_array($request->kode_barang)) {
                foreach ($request->kode_barang as $index => $kode_barang) {
                    if (
                        isset($request->qty_po[$index]) &&
                        isset($request->qty_actual[$index]) &&
                        isset($request->final_qty[$index])
                    ) {
                        $stock = Stock::where('kode_barang', $kode_barang)->first();
                        if ($stock) {
                            $finalQtyLama = 0;
                            foreach ($detailInboundLama as $detailLama) {
                                if ($detailLama->kode_barang == $kode_barang) {
                                    $finalQtyLama = (int)$detailLama->final_qty;
                                    break;
                                }
                            }
                            $stock->stock = $stock->stock - $finalQtyLama + (int)$request->final_qty[$index];
                            $stock->save();
                        }
                        $imagePath = null;
                        $detailLama = $detailInboundLama->where('kode_barang', $kode_barang)->first();
                        if ($request->hasFile("gambar.$index")) {
                            if ($detailLama && $detailLama->gambar) {
                                Storage::delete('public/' . $detailLama->gambar);
                            }
                            $image = $request->file("gambar.$index");
                            $imagePath = $image->store('uploads', 'public');
                        } else {
                            $imagePath = $detailLama ? $detailLama->gambar : null;
                        }
                        DetailInbound::create([
                            'kode_po' => $inbound->kode_po,
                            'kode_barang' => $kode_barang,
                            'qty_po' => $request->qty_po[$index],
                            'qty_actual' => $request->qty_actual[$index],
                            'reject' => $request->reject[$index] ?? 0,
                            'final_qty' => $request->final_qty[$index],
                            'satuan' => $request->satuan[$index],
                            'keterangan' => $request->keterangan[$index],
                            'exp' => $request->exp[$index],
                            'gambar' => $imagePath,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Data kuantitas tidak boleh kosong untuk item ke-' . ($index + 1)
                        ], 422);
                    }
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data item barang tidak valid atau tidak ditemukan.'
                ], 422);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate dan stok serta gambar diperbarui!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saat update PO: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_po)
    {
        try {
            $inbound = Inbound::where('kode_po', $kode_po)->first();

            if (!$inbound) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data inbound tidak ditemukan!'
                ], 404);
            }
            DB::transaction(function () use ($inbound) {
                foreach ($inbound->details as $detail) {
                    if ($detail->gambar) {
                        Storage::delete('public/' . $detail->gambar);
                    }
                }
                $inbound->details()->delete();
                $inbound->delete();
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
