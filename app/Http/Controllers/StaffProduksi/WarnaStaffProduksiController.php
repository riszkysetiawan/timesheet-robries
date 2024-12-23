<?php


namespace App\Http\Controllers\StaffProduksi;


use App\Http\Controllers\Controller;

use App\Models\Warna;
use App\Http\Requests\StoreWarnaRequest;
use App\Http\Requests\UpdateWarnaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\WarnaExport;
use Maatwebsite\Excel\Facades\Excel;

class WarnaStaffProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function downloadExcel()
    {
        return Excel::download(new WarnaExport, 'warna.xlsx');
    }
    function index(Request $request)
    {
        if ($request->ajax()) {
            $satuans = Warna::select(['id', 'warna', 'keterangan']); // Pilih kolom yang diperlukan saja

            return DataTables::of($satuans)
                ->addIndexColumn()
                ->addColumn('action', function ($satuan) {
                    $editUrl = route('warna.production-staff.edit', Crypt::encryptString($satuan->id));
                    return '
                        <a href="javascript:void(0)" onclick="confirmDelete(' . $satuan->id . ')" class="btn btn-outline-danger btn-rounded mb-2 me-4">
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('staff-produksi.warna.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff-produksi.warna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'warna' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'warna.required' => 'Kolom warna wajib diisi.',
            'warna.string' => 'Kolom warna harus berupa teks.',
            'warna.max' => 'Kolom warna tidak boleh lebih dari 255 karakter.',
            'keterangan.string' => 'Kolom keterangan harus berupa teks.',
            'keterangan.max' => 'Kolom keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $warna = new Warna();
        $warna->warna = $request->warna;
        $warna->keterangan = $request->keterangan;

        $warna->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Warna barang berhasil ditambahkan!'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $decryptedId = Crypt::decryptString($id);
        $warna = Warna::findOrFail($decryptedId);

        return view('staff-produksi.warna.update', compact('warna'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'warna' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'warna.required' => 'Kolom warna wajib diisi.',
            'warna.string' => 'Kolom warna harus berupa teks.',
            'warna.max' => 'Kolom warna tidak boleh lebih dari 255 karakter.',
            'keterangan.string' => 'Kolom keterangan harus berupa teks.',
            'keterangan.max' => 'Kolom keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $warna = Warna::findOrFail($decryptedId);
        $warna->warna = $request->warna;
        $warna->keterangan = $request->keterangan;

        $warna->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Warna barang berhasil diupdate!'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warna = Warna::find($id);

        if (!$warna) {
            return response()->json([
                'status' => 'error',
                'message' => 'warna barang tidak ditemukan!'
            ], 404);
        }

        $warna->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'warna barang berhasil dihapus!'
        ]);
    }
}
