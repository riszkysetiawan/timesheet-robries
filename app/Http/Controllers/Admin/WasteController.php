<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Exports\WasteExport;
use App\Models\Waste;
use App\Http\Requests\StoreWasteRequest;
use App\Http\Requests\UpdateWasteRequest;
use App\Models\AlasanWaste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Barang;
use App\Models\Stock;
use PDF;
use App\Exports\WastesExport;
use App\Imports\WasteImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $wastes = Waste::with('barang', 'alasanWaste')
                ->select(['id', 'kode_barang', 'jumlah', 'id_alasan', 'foto'])
                ->orderBy('created_at', 'desc'); // Tambahkan order by di sini

            return DataTables::of($wastes)
                ->addIndexColumn()
                ->addColumn('total_waste', function ($waste) {
                    return Waste::where('kode_barang', $waste->kode_barang)->sum('jumlah');
                })
                ->addColumn('action', function ($waste) {
                    $editUrl = route('waste.admin.edit', Crypt::encryptString($waste->id));
                    return '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $waste->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
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
                ->addColumn('nama_barang', function ($waste) {
                    return $waste->barang->nama_barang ?? 'Belum Ada';
                })
                ->addColumn('alasan', function ($waste) {
                    return $waste->alasan_waste->alasan ?? '';
                })
                ->addColumn('foto', function ($waste) {
                    if ($waste->foto) {
                        $imageUrl = asset('storage/' . $waste->foto);
                        return '<a href="javascript:void(0);" onclick="showImageModal(\'' . $imageUrl . '\')">
                                    <img src="' . $imageUrl . '" alt="Bukti Foto" style="max-width: 100px;">
                                </a>';
                    } else {
                        return 'Tidak ada foto';
                    }
                })
                ->rawColumns(['action', 'foto'])
                ->make(true);
        }

        return view('superadmin.waste.index');
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
        Excel::import(new WasteImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data Waste berhasil diupload!'
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangs = Barang::all();
        $alasans = AlasanWaste::all();
        return view('superadmin.waste.create', compact('barangs', 'alasans'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kode_barang.*' => 'required|exists:barang,kode_barang',
                'id_alasan.*' => 'required|exists:alasan_waste,id',
                'waste.*' => 'required|numeric|min:1',
                'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'kode_barang.*.required' => 'Kode barang wajib diisi.',
                'kode_barang.*.exists' => 'Barang yang dipilih tidak ditemukan dalam database.',
                'id_alasan.*.required' => 'Alasan waste wajib dipilih.',
                'id_alasan.*.exists' => 'Alasan waste yang dipilih tidak valid.',
                'waste.*.required' => 'Jumlah waste wajib diisi.',
                'waste.*.numeric' => 'Jumlah waste harus berupa angka.',
                'waste.*.min' => 'Jumlah waste minimal adalah 1.',
                'foto.*.required' => 'Foto wajib diunggah.',
                'foto.*.image' => 'File harus berupa gambar.',
                'foto.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
                'foto.*.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }
            foreach ($request->kode_barang as $index => $kode_barang) {
                $stock = Stock::where('kode_barang', $kode_barang)->first();

                if (!$stock) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Jumlah waste tidak boleh melebihi jumlah stok saat ini!',
                    ], 422);
                }

                if ($request->waste[$index] > $stock->stock) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Stok untuk barang kode {$kode_barang}
                         tidak mencukupi untuk menambah waste sebesar {$request->waste[$index]}!
                          Stok saat ini hanya {$stock->stock}."
                    ], 400);
                }

                $filePath = null;
                if ($request->hasFile("foto.{$index}")) {
                    $file = $request->file("foto.{$index}");
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('waste_fotos', $filename, 'public');
                }

                $stock->stock -= $request->waste[$index];
                $stock->save();
                $waste = new Waste();
                $waste->kode_barang = $kode_barang;
                $waste->jumlah = $request->waste[$index];
                $waste->id_alasan = $request->id_alasan[$index];
                $waste->foto = $filePath;
                $waste->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Waste berhasil ditambahkan, dan stok telah dikurangi!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan waste: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data waste. Silakan coba lagi atau hubungi administrator.'
            ], 500);
        }
    }

    public function uploadFile()
    {
        return view('superadmin.waste.upload');
    }

    public function downloadExcel()
    {
        return Excel::download(new WasteExport, 'wastes.xlsx');
    }

    public function downloadPdf()
    {
        $wastes = Waste::with('barang', 'alasan_waste')->get();
        $pdf = PDF::loadView('superadmin.waste.pdf', ['wastes' => $wastes]);

        return $pdf->download('wastes.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteStock $wasteStock)
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
            $waste = Waste::where('id', $decryptedKodeBarang)->firstOrFail();
            $stock = Stock::where('kode_barang', $waste->kode_barang)->firstOrFail();
            $alasans = AlasanWaste::all();
            $barangs = Barang::all();
            return view('superadmin.waste.update', compact('waste', 'barangs', 'stock', 'alasans'));
        } catch (DecryptException $e) {
            return redirect()->route('waste-barang.admin.index')->withErrors('Terjadi Kesalahan.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('waste-barang.admin.index')->withErrors('Waste atau Stock Tidak Ditemukan.');
        }
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            $validated = $request->validate([
                'waste_old' => 'required|numeric|min:0',
                'id_alasan' => 'required|exists:alasan_waste,id',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'waste_old.required' => 'Jumlah waste wajib diisi.',
                'waste_old.numeric' => 'Jumlah waste harus berupa angka.',
                'waste_old.min' => 'Jumlah waste minimal 0.',
                'id_alasan.required' => 'Alasan waste wajib dipilih.',
                'id_alasan.exists' => 'Alasan waste yang dipilih tidak valid.',
                'foto.image' => 'File harus berupa gambar.',
                'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
                'foto.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            ]);
            $waste = Waste::where('id', $decryptedId)->firstOrFail();
            $barangStock = Stock::where('kode_barang', $waste->kode_barang)->firstOrFail();
            $newWaste = $request->input('waste_old');
            $wasteDifference = $newWaste - $waste->jumlah;
            if ($newWaste > $barangStock->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jumlah waste tidak boleh melebihi jumlah stok saat ini!',
                ], 400);
            }
            $remainingStock = $barangStock->stock - $wasteDifference;
            if ($remainingStock < 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stock tidak mencukupi untuk perubahan waste!',
                ], 400);
            }
            if ($request->hasFile('foto')) {
                if ($waste->foto && \Storage::exists('public/' . $waste->foto)) {
                    \Storage::delete('public/' . $waste->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('waste_fotos', $filename, 'public');
                $waste->foto = $filePath;
            }
            $waste->jumlah = $newWaste;
            $waste->id_alasan = $request->id_alasan;
            $waste->save();
            $barangStock->stock = $remainingStock;
            $barangStock->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Waste berhasil diperbarui, dan stock telah disesuaikan!',
                'remaining_stock' => $remainingStock,
                'total_waste' => $newWaste
            ]);
        } catch (\Exception $e) {
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
        $waste = Waste::find($id);
        if (!$waste) {
            return response()->json([
                'status' => 'error',
                'message' => 'Waste Barang tidak ditemukan!'
            ], 404);
        }
        $waste->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Waste berhasil dihapus!'
        ]);
    }
}
