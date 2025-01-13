<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Oven;
use App\Http\Requests\StoreOvenRequest;
use App\Http\Requests\UpdateOvenRequest;
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

class OvenController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ovens = Oven::all();

            return DataTables::of($ovens)
                ->addIndexColumn() // Tambahkan baris ini untuk kolom nomor urut
                ->addColumn('action', function ($oven) {
                    $editUrl = route('oven.admin.edit', Crypt::encryptString($oven->id));
                    return '
                        <a class="btn btn-outline-danger btn-rounded mb-2 me-4" href="javascript:void(0)" onclick="confirmDelete(' . $oven->id . ')" type="button">
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
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('superadmin.oven.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.oven.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'nama wajib diisi.',
            'nama.string' => 'nama harus berupa teks.',
            'nama.max' => 'nama tidak boleh lebih dari 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $oven = new Oven();
        $oven->nama = $request->nama;
        $oven->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Oven Barang berhasil ditambahkan!'
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
        $oven = Oven::findOrFail($decryptedId);

        return view('superadmin.oven.update', compact('oven'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $decryptedId = Crypt::decryptString($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama nama wajib diisi.',
            'nama.string' => 'Nama nama harus berupa teks.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $oven = Oven::findOrFail($decryptedId);
        $oven->nama = $request->nama;
        $oven->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Oven berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $oven = Oven::find($id);
        if (!$oven) {
            return response()->json([
                'status' => 'error',
                'message' => 'oven tidak ditemukan!'
            ], 404);
        }

        $oven->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'oven berhasil dihapus!'
        ]);
    }
}
