<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\PurchaseOrder;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\ProfileCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DetailPurchaseOrder;
use App\Models\SatuanBarang;
use Illuminate\Support\Facades\Crypt;
use PDF;
use App\Exports\PurchaseOrdersExport;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->input('status');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query dengan filter status dan tanggal
            $purchaseOrders = PurchaseOrder::with('supplier')
                ->where('status', $status)
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tgl_buat', [$startDate, $endDate]);
                })
                ->orderBy('tgl_buat', 'desc');

            return DataTables::of($purchaseOrders)
                ->addIndexColumn()
                ->addColumn('action', function ($po) {
                    $editUrl = route('pembelian.admin.edit', Crypt::encryptString($po->id));
                    $detailUrl = route('detail.pembelian.admin', Crypt::encryptString($po->id));
                    $acceptUrl = route('terima.pembelian.admin', Crypt::encryptString($po->id));
                    // Tombol Preview
                    $previewButton = '
                        <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview" data-id="' . $po->id . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M21 12c-2.25 4.5-6.75 4.5-9 0s-6.75-4.5-9 0"></path>
                            </svg>
                            Preview
                        </button>';

                    // Tombol Terima
                    $acceptButton = $po->status === 'Belum Diterima' ? '
                        <a href="' . $acceptUrl . '" class="btn btn-outline-secondary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                                <path d="M9 12l2 2 4-4"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            Terima
                        </a>' : '';

                    // Tombol Edit
                    $editButton = '
                        <a href="' . $editUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>';

                    // Tombol Delete
                    $deleteButton = '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $po->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14H7L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            Delete
                        </a>';

                    // Tombol Detail
                    $detailButton = '
                        <a href="' . $detailUrl . '" class="btn btn-outline-secondary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 5v2"></path>
                                <path d="M12 15v2"></path>
                            </svg>
                            Detail
                        </a>';

                    return $previewButton . $acceptButton . $editButton . $deleteButton . $detailButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.pembelian.index');
    }


    public function downloadLaporan($id)
    {
        $purchaseOrderId = Crypt::decryptString($id);

        $purchaseOrder = PurchaseOrder::with('details.barang', 'supplier')->findOrFail($purchaseOrderId);
        $barangs = Barang::all();
        $satuans = SatuanBarang::all();
        $profile = CompanyProfile::first();
        $pdf = PDF::loadView('superadmin.laporan.pembelian_pdf', compact('purchaseOrder', 'profile'));
        // Kembalikan PDF untuk didownload
        return $pdf->download('purchase_order_' . $purchaseOrder->kode_po . '.pdf');
    }
    public function downloadExcel(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        return Excel::download(new PurchaseOrdersExport($startDate, $endDate), 'purchase_orders_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function laporan(Request $request)
    {
        if ($request->ajax()) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Query dengan filter tanggal
            $purchaseOrders = PurchaseOrder::with('details.barang', 'supplier')
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    return $query->whereBetween('tgl_buat', [$startDate, $endDate]);
                })
                ->orderBy('tgl_buat', 'desc');

            return DataTables::of($purchaseOrders)
                ->addIndexColumn()
                ->addColumn('supplier_name', function ($purchaseOrder) {
                    return optional($purchaseOrder->supplier)->nama_supplier ?? 'Tidak Ada Supplier';
                })
                ->addColumn('action', function ($purchaseOrder) {
                    $poId = Crypt::encryptString($purchaseOrder->id);
                    $detailUrl = route('detail.pembelian.admin', $poId);
                    $downloadUrl = route('download.laporan.pembelian.admin.pdf', $poId);

                    // Tombol Detail
                    $detailButton = '
                        <a href="' . $detailUrl . '" class="btn btn-outline-primary btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 5v2"></path>
                                <path d="M12 15v2"></path>
                            </svg>
                            Detail
                        </a>';

                    // Tombol Download PDF
                    $downloadButton = '
                        <a href="' . $downloadUrl . '" class="btn btn-outline-success btn-rounded mb-2 me-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Download PDF
                        </a>';

                    // Tombol Preview
                    $previewButton = '
                        <button type="button" class="btn btn-outline-info btn-rounded mb-2 me-4 btn-preview" data-id="' . $purchaseOrder->id . '">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M21 12c-2.25 4.5-6.75 4.5-9 0s-6.75-4.5-9 0"></path>
                            </svg>
                            Preview
                        </button>';

                    return $detailButton . $downloadButton . $previewButton;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.laporan.pembelian');
    }




    public function generatePDF($encryptedId)
    {
        try {
            $decryptedId = Crypt::decryptString($encryptedId);
            $purchaseOrder = PurchaseOrder::with('details.barang', 'supplier')->findOrFail($decryptedId);
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $profile = CompanyProfile::first();
            $pdf = PDF::loadView('superadmin.pembelian.pdf', compact('purchaseOrder', 'barangs', 'satuans', 'profile'));
            $fileName = 'invoice-' . $purchaseOrder->kode_po . '.pdf';
            Storage::put('public/pdfs/' . $fileName, $pdf->output());
            return response()->json([
                'status' => 'success',
                'url' => Storage::url('public/pdfs/' . $fileName),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to generate PDF. Please try again later.'
            ], 500);
        }
    }
    public function preview($id)
    {
        $purchaseOrder = PurchaseOrder::with('supplier', 'details.barang')->findOrFail($id);

        return response()->json([
            'purchaseOrder' => $purchaseOrder,
            'supplier' => $purchaseOrder->supplier,
            'details' => $purchaseOrder->details,
        ]);
    }



    public function getBarang($kode_barang)
    {
        $barang = Barang::with('satuan')->where('kode_barang', $kode_barang)->first(); // Mengambil relasi satuan

        if ($barang) {
            return response()->json([
                'barang' => $barang,
                'satuan' => $barang->satuan->satuan
            ]);
        } else {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastPo = PurchaseOrder::latest('id')->first();
        if ($lastPo) {
            $lastNumber = explode('-', $lastPo->kode_po)[1];
            $newNumber = (int)$lastNumber + 1;
        } else {
            $newNumber = 1000;
        }
        $poCode = 'PO-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT) . '-' . date('d-m-Y');

        $suppliers = Supplier::all();
        $barangs = Barang::all();
        $satuans = SatuanBarang::all();
        $profile = CompanyProfile::first();

        return view('superadmin.pembelian.create', compact('suppliers', 'barangs', 'profile', 'poCode', 'satuans'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_po' => 'required|unique:purchase_order,kode_po',
            'kode_pi' => 'nullable|unique:purchase_order,kode_pi',
            'id_supplier' => 'required|exists:supplier,id',
            'tgl_buat' => 'required|date',
            'eta' => 'required|date',
            'total' => 'required|numeric',
            'status' => 'required|string',
            'kode_barang.*' => 'required|exists:barang,kode_barang',
            'qty.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'satuan.*' => 'required|string',
            'sub_total.*' => 'required|numeric',
            'keterangan_tambahan.*' => 'nullable|string',
        ], [
            'kode_po.required' => 'Kode PO wajib diisi.',
            'kode_po.unique' => 'Kode PO sudah terdaftar.',
            'id_supplier.required' => 'Supplier wajib dipilih.',
            'id_supplier.exists' => 'Supplier tidak ditemukan.',
            'tgl_buat.required' => 'Tanggal pembuatan wajib diisi.',
            'eta.required' => 'Tanggal ETA wajib diisi.',
            'qty.*.required' => 'Jumlah barang wajib diisi.',
            'qty.*.min' => 'Jumlah barang minimal adalah 1.',
            'harga.*.required' => 'Harga barang wajib diisi.',
            'satuan.*.required' => 'Satuan barang wajib diisi.',
            'sub_total.*.required' => 'Subtotal barang wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data ke tabel `purchase_order`
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->kode_po = $request->kode_po;
            $purchaseOrder->kode_pi = $request->kode_pi;
            $purchaseOrder->id_supplier = $request->id_supplier;
            $purchaseOrder->tgl_buat = $request->tgl_buat;
            $purchaseOrder->eta = $request->eta;
            $purchaseOrder->total = $request->total;
            $purchaseOrder->status = $request->status;
            $purchaseOrder->catatan = $request->catatan; // Tambahkan catatan
            $purchaseOrder->save();

            // Simpan data ke tabel `detail_purchase_order`
            foreach ($request->kode_barang as $index => $kode_barang) {
                $detailPurchaseOrder = new DetailPurchaseOrder();
                $detailPurchaseOrder->kode_po = $purchaseOrder->kode_po;
                $detailPurchaseOrder->kode_barang = $kode_barang; // Menggunakan `kode_produk` sesuai tabel
                $detailPurchaseOrder->qty = $request->qty[$index];
                $detailPurchaseOrder->harga = $request->harga[$index];
                $detailPurchaseOrder->satuan = $request->satuan[$index];
                $detailPurchaseOrder->sub_total = $request->sub_total[$index];
                $detailPurchaseOrder->keterangan = $request->keterangan_tambahan[$index] ?? null;
                $detailPurchaseOrder->save();
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $purchaseOrder = PurchaseOrder::with('details.barang', 'supplier')->findOrFail($id);
            $suppliers = Supplier::all();
            $barangs = Barang::all();
            $satuans = SatuanBarang::all();
            $profile = CompanyProfile::first();

            return view('superadmin.pembelian.detail', compact('purchaseOrder', 'suppliers', 'barangs', 'satuans', 'profile'));
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

            return view('superadmin.pembelian.update', compact('purchaseOrder', 'suppliers', 'barangs', 'satuans', 'profile'));
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
            DB::beginTransaction();

            // Dekripsi ID
            $id = Crypt::decryptString($encryptedId);

            // Normalize total, harga, dan sub_total untuk menghapus format angka
            $request->merge([
                'total' => str_replace(',', '', $request->total),
                'harga' => array_map(function ($value) {
                    return str_replace([',', 'Rp'], '', $value);
                }, $request->harga),
                'sub_total' => array_map(function ($value) {
                    return str_replace([',', 'Rp'], '', $value);
                }, $request->sub_total)
            ]);

            // Validasi input
            $request->validate([
                'id_supplier' => 'required|exists:supplier,id',
                'tgl_buat' => 'required|date',
                'eta' => 'required|date',
                'total' => 'required|numeric',
                'kode_pi' => 'nullable|unique:purchase_order,kode_pi',
                'kode_barang.*' => 'required|exists:barang,kode_barang',
                'qty.*' => 'required|numeric|min:1',
                'harga.*' => 'required|numeric',
                'satuan.*' => 'required|string',
                'sub_total.*' => 'required|numeric',
                'keterangan_tambahan.*' => 'nullable|string',
            ], [
                'id_supplier.required' => 'ID Supplier wajib diisi.',
                'id_supplier.exists' => 'ID Supplier tidak valid.',
                'tgl_buat.required' => 'Tanggal pembuatan wajib diisi.',
                'tgl_buat.date' => 'Format tanggal pembuatan tidak valid.',
                'eta.required' => 'Tanggal ETA wajib diisi.',
                'eta.date' => 'Format tanggal ETA tidak valid.',
                'total.required' => 'Total transaksi wajib diisi.',
                'total.numeric' => 'Total transaksi harus berupa angka.',
                'kode_barang.*.required' => 'Kode barang wajib diisi.',
                'kode_barang.*.exists' => 'Kode barang tidak ditemukan di database.',
                'qty.*.required' => 'Jumlah barang (Qty) wajib diisi.',
                'qty.*.numeric' => 'Jumlah barang (Qty) harus berupa angka.',
                'qty.*.min' => 'Jumlah barang (Qty) tidak boleh kurang dari 1.',
                'harga.*.required' => 'Harga barang wajib diisi.',
                'harga.*.numeric' => 'Harga barang harus berupa angka.',
                'satuan.*.required' => 'Satuan barang wajib diisi.',
                'satuan.*.string' => 'Satuan barang harus berupa teks.',
                'sub_total.*.required' => 'Subtotal barang wajib diisi.',
                'sub_total.*.numeric' => 'Subtotal barang harus berupa angka.',
            ]);

            // Update tabel `purchase_order`
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->id_supplier = $request->id_supplier;
            $purchaseOrder->tgl_buat = $request->tgl_buat;
            $purchaseOrder->eta = $request->eta;
            $purchaseOrder->kode_pi = $request->kode_pi;
            $purchaseOrder->total = $request->total;
            $purchaseOrder->catatan = $request->catatan ?? null;
            $purchaseOrder->save();

            // Hapus data lama di tabel `detail_purchase_order`
            $purchaseOrder->details()->delete();

            // Simpan ulang data detail baru
            foreach ($request->kode_barang as $index => $kode_barang) {
                DetailPurchaseOrder::create([
                    'kode_po' => $purchaseOrder->kode_po,
                    'kode_barang' => $kode_barang,
                    'qty' => $request->qty[$index],
                    'harga' => $request->harga[$index],
                    'satuan' => $request->satuan[$index],
                    'sub_total' => $request->sub_total[$index],
                    'keterangan' => $request->keterangan_tambahan[$index] ?? '',
                ]);
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil diupdate!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $purchaseOrder = PurchaseOrder::findOrFail($id);
                DetailPurchaseOrder::where('kode_po', $purchaseOrder->kode_po)->delete();
                $purchaseOrder->delete();
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Purchase Order berhasil dihapus.'
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus Purchase Order: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghapus Purchase Order.'
            ], 500);
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
}
